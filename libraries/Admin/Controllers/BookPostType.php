<?php namespace Pho\Admin\Controllers;
/**
 * BookPostType
 */
use Banhmi\Controllers\PostType;

final class BookPostType extends PostType
{
  /**
   * Do notification
   *
   * @see  https://developer.wordpress.org/reference/hooks/post_updated_messages/
   *
   * @param  array  $messages  All available messages.
   *
   * @return  array  $messages
   */
  function notify($messages)
  {
    $messages['book'] = [
      0  => '', // Unused. Messages start at index 1.
      1  => __('Book updated.', 'pho'),
      2  => __('Custom field updated.', 'pho'),
      3  => __('Custom field deleted.', 'pho'),
      4  => __('Book updated.', 'pho'),
      5  => isset($_GET['revision']) ? __('Book restored to revision from', 'pho') . ' ' . wp_post_revision_title( absint($_GET['revision']) ) : false,
      6  => __('Book published.', 'pho'),
      7  => __('Book saved.', 'pho'),
      8  => __('Book submitted.', 'pho'),
      9  => __('Book scheduled.', 'pho'),
      10 => __('Book draft updated.', 'pho')
    ];

    return $messages;
  }
}
