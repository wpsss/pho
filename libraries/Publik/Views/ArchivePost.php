<?php namespace Pho\Publik\Views;
/**
 * ArchivePost
 */
final class ArchivePost extends AbstractArticle
{
  /**
   * Render
   *
   * @param  object  $post  \WP_Post
   */
  function render($post)
  {
    ?><article class="entry archive-post" itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
      <a href="<?= get_permalink($post) ?>" itemprop="url">
        <?php $this->theArchiveTitle($post) ?>
      </a>
      <?php $this->theExcerpt($post) ?>
    </article><?php
  }
}
