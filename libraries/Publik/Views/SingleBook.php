<?php namespace Pho\Publik\Views;
/**
 * SingleBook
 */
final class SingleBook extends AbstractArticle
{
  /**
   * Render
   *
   * @param  object  $post  \WP_Post
   */
  function render($post)
  {
    ?><article class="entry single-book" itemscope itemtype="https://schema.org/Book">
      <header class="entry-header"><?php
        $this->theThumbnail($post, 'medium');
        $this->theSingleTitle($post);
        echo __('Posted on', 'pho') . ': ';
        $this->thePubDate($post);
      ?></header><?php
        $this->theMeta($post);
        $this->theContent($post)
      ?><footer class="entry-footer"><?php
        if ( !empty($post->post_terms->book_genre) ) {
          echo __('Categorized as', 'pho') . ': ';
          $this->theTerms($post, 'book_genre');
        }
        if ( !empty($post->post_terms->book_genre) && !empty($post->post_terms->post_tag) )
          echo ' | ';
        if ( !empty($post->post_terms->post_tag) ) {
          echo __('Tagged with', 'pho') . ': ';
          $this->theTerms($post, 'post_tag');
        }
      ?></footer>
    </article><?php
  }

  /**
   * Meta
   */
  private function theMeta(\WP_Post $post)
  {
    $meta = $post->post_meta->_book_metadata;

    ?><table class="book-details"><tbody><?php
      if ($meta['price']) : ?>
        <tr>
          <td><?= __('Price', 'pho') ?></td>
          <td itemprop="price"><?= $meta['price'] ?></td>
        </tr><?php
      endif;
      if ($meta['isbn']) : ?>
        <tr>
          <td><?= __('ISBN', 'pho') ?></td>
          <td itemprop="isbn"><?= $meta['isbn'] ?></td>
        </tr><?php
      endif;
      if ($post->post_terms->book_genre) : ?>
        <tr>
          <td><?= __('Genre', 'pho') ?></td>
          <td itemprop="genre"><?= $post->post_terms->book_genre[0]->name ?></td>
        </tr><?php
      endif;
      if ($meta['bookEdition']) : ?>
        <tr>
          <td><?= __('Edition', 'pho') ?></td>
          <td itemprop="bookEdition"><?= $meta['bookEdition'] ?></td>
        </tr><?php
      endif;
      if ($meta['bookFormat']) : ?>
        <tr>
          <td><?= __('Formats', 'pho') ?></td>
          <td itemprop="bookFormat"><?= $meta['bookFormat'] ?></td>
        </tr><?php
      endif;
      if ($meta['numberOfPages']) : ?>
        <tr>
          <td><?= __('Number of Pages', 'pho') ?></td>
          <td itemprop="numberOfPages"><?= $meta['numberOfPages'] ?></td>
        </tr><?php
      endif;
    ?></tbody></table><?php
  }
}
