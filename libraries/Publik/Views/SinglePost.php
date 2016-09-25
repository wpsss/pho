<?php namespace Pho\Publik\Views;
/**
 * SinglePost
 */
final class SinglePost extends AbstractArticle
{
  /**
   * Render
   *
   * @param  object  $post  \WP_Post
   */
  function render($post)
  {
    ?><article class="entry single-post" itemscope itemtype="https://schema.org/Article">
      <header class="entry-header"><?php
        $this->theThumbnail($post, 'large');
        $this->theSingleTitle($post);
        echo __('Posted on', 'pho') . ': ';
        $this->thePubDate($post);
      ?></header><?php
      $this->theContent($post);
      ?><footer class="entry-footer"><?php
        if ( !empty($post->post_terms->post_tag) ) {
          echo __('Tagged with', 'pho') . ': ';
          $this->theTerms($post, 'post_tag');
        }
      ?></footer>
    </article><?php
  }
}
