<?php namespace Pho\Helpers;
/**
 * PostRepository
 */
final class PostRepository
{
  /**
   * WordPress DBAL
   *
   * @var  object
   */
  private $db;

  /**
   * Constructor
   */
  function __construct(\wpdb $wpdb)
  {
    $this->db = $wpdb;
  }

  /**
   * Create a post
   */
  function create(\WP_Post $post)
  {
    $post->post_meta = $this->getMeta($post);
    $post->post_terms = $this->getTerms($post); // !Expensive.
    $post->post_author = $this->getAuthor($post);
    $post->post_excerpt = $this->getExcerpt($post);

    return $post;
  }

  /**
   * Get post excerpt
   *
   * @param  int  $max  Maximum characters of excerpt.
   */
  private function getExcerpt(\WP_Post $post, $max = 225)
  {
    if ( empty($post->post_excerpt) ) {
      $excerpt = trim( preg_replace( '~\[\/?[^\]]+\]~', '', strip_tags($post->post_content) ) );
      if ( (0 < $max) && ( mb_strlen($excerpt) > $max ) ) {
        $excerpt = mb_substr($excerpt, 0, $max);
        $excerpt = mb_substr( $excerpt, 0, mb_strrpos($excerpt, ' ') );
      }
      return $excerpt;
    }

    return $post->post_excerpt;
  }

  /**
   * Get post meta
   */
  private function getMeta(\WP_Post $post)
  {
    $meta = get_post_meta($post->ID);

    return $this->unserializeMeta($meta);
  }

  /**
   * Get post terms
   */
  private function getTerms(\WP_Post $post, $terms = [])
  {
    $taxonomies = get_object_taxonomies($post);

    if ( !empty($taxonomies) ) {
      foreach ($taxonomies as $taxonomy) {
        $terms[$taxonomy] = get_the_terms($post, $taxonomy);
      }
    }

    return (object)$terms;
  }

  /**
   * Get post author
   */
  private function getAuthor(\WP_Post $post)
  {
    $user = new \WP_User;
    $user->data = $user::get_data_by('id', $post->post_author);
    $user->user_meta = $this->unserializeMeta( get_user_meta($post->post_author) );
    $user->user_url = $user->user_url ? : get_author_posts_url($post->post_author, $user->user_nicename);

    return $user;
  }

  /**
   * Maybe unserialize metadata
   */
  private function unserializeMeta(array $meta, $output = [])
  {
    foreach ($meta as $key => $value) {
      $output[$key] = maybe_unserialize($value[0]);
    }

    return (object)$output;
  }
}
