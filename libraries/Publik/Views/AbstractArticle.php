<?php namespace Pho\Publik\Views;
/**
 * AbstractArticle
 *
 * Here come reusable composites for derived posts.
 */
use Pho\Helpers\Html;
 
abstract class AbstractArticle extends PublicView
{
  /**
   * Thumbnail.
   */
  protected function theThumbnail(\WP_Post $post, $size = 'thumbnail', $attrs = ['itemprop' => 'image'])
  {
    if ( !empty($post->post_meta->_thumbnail_id) )
      echo wp_get_attachment_image($post->post_meta->_thumbnail_id, $size, false, $attrs);
  }

  /**
   * Title of a single post.
   */
  protected function theSingleTitle(\WP_Post $post, $class = 'entry-title')
  {
    ?><h1 class="<?= $class ?>" itemprop="name">
      <?= Html::encode($post->post_title) ?>
    </h1><?php
  }

  /**
   * Title of an archived post.
   */
  protected function theArchiveTitle(\WP_Post $post, $class = 'entry-headline')
  {
    ?><h2 class="<?= $class ?>" itemprop="name">
      <?= Html::encode($post->post_title) ?>
    </h2><?php
  }

  /**
   * Published date.
   */
  protected function thePubDate(\WP_Post $post, $class = 'entry-pubdate')
  {
    $time = strtotime($post->post_date);

    ?><time class="<?= $class ?>" itemprop="datePublished" datetime="<?= date('c', $time) ?>">
      <?= date_i18n( get_option('date_format'), $time ) ?>
    </time><?php
  }

  /**
   * Modified date.
   */
  protected function theModDate(\WP_Post $post, $class = 'entry-moddate')
  {
    $time = strtotime($post->post_modified);

    ?><time class="<?= $class ?>" itemprop="dateModified" datetime="<?= date('c', $time) ?>">
      <?= date_i18n( get_option('date_format'), $time ) ?>
    </time><?php
  }

  /**
   * Author.
   */
  protected function theAuthor(\WP_Post $post, $class = 'entry-author')
  {
    ?><address class="<?= $class ?>" itemprop="author" itemscope itemtype="https://schema.org/Person">
      <a rel="author" href="<?= esc_url($post->post_author->user_url) ?>">
        <span itemprop="name">
          <?= $post->post_author->display_name ?>
        </span>
      </a>
    </address><?php
  }

  /**
   * Excerpt.
   */
  protected function theExcerpt(\WP_Post $post, $class = 'entry-excerpt')
  {
    ?><p class="<?= $class ?>" itemprop="description">
      <?= Html::encode($post->post_excerpt) ?>&hellip;
    </p><?php
  }

  /**
   * Content.
   */
  protected function theContent(\WP_Post $post, $class = 'entry-content')
  {
    ?><div class="<?= $class ?>" itemprop="articleBody">
      <?= apply_filters('the_content', $post->post_content) ?>
    </div><?php
  }

  /**
   * Terms.
   */
  protected function theTerms(\WP_Post $post, $taxonomy = 'post_tag', $sep = ', ', $terms = [])
  {
    $the_terms = $post->post_terms->$taxonomy;

    foreach ($the_terms as $term) {
      $terms[] = '<a rel="tag" href="' . get_term_link($term, $taxonomy) . '"><span itemprop="keywords">' . Html::encode($term->name) . '</span></a>';
    }

    echo implode($sep, $terms);
  }
}
