<?php namespace Pho\Admin\Models;
/**
 * BookMetaBox
 */
final class BookMetaBox extends AdminModel
{
  /**
   * Constructor
   */
  function __construct()
  {
    $id = isset($_GET['post']) ? absint($_GET['post']) : 0;

    $this->data = [
      'id'       => 'book-meta-book',
      'key'      => '_book_metadata',
      'title'    => __('Book Details', 'pho'),
      'screen'   => 'book',
      'context'  => 'normal',
      'priority' => 'high',
      'fields'   => [
        [
          'name'        => 'price',
          'label'       => __('Price', 'pho'),
          'description' => __('E.g. $7.5', 'pho')
        ],
        [
          'name'        => 'isbn',
          'label'       => __('ISBN', 'pho'),
          'description' => __('E.g. 978-1118442272', 'pho')
        ],
        [
          'name'        => 'bookEdition',
          'label'       => __('Edition', 'pho'),
          'description' => __('E.g. 2nd Edition', 'pho')
        ],
        [
          'name'        => 'bookFormat',
          'label'       => __('Format', 'pho'),
          'description' => __('E.g. Paperback', 'pho')
        ],
        [
          'name'        => 'numberOfPages',
          'label'       => __('Number of Pages', 'pho'),
          'description' => __('E.g. 456', 'pho')
        ]
      ],
      'values' => get_post_meta($id, '_book_metadata', true)
    ];
  }

  /**
   * Do sanitization
   *
   * @var  array  $meta  An array of raw meta values.
   *
   * @return  array  $meta  An array of sanitized meta values.
   */
  function sanitize($meta)
  {
    $meta['isbn'] = sanitize_text_field($meta['isbn']);
    $meta['price'] = sanitize_text_field($meta['price']);
    $meta['bookFormat'] = sanitize_text_field($meta['bookFormat']);
    $meta['bookEdition'] = sanitize_text_field($meta['bookEdition']);
    $meta['numberOfPages'] = absint($meta['numberOfPages']);

    return $meta;
  }

  /**
   * Save metadata
   *
   * @param  int  $book_id  ID of current book.
   */
  function save($book_id)
  {
    if ( defined('DOING_AJAX') && DOING_AJAX ) return;

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

    if ( !current_user_can('edit_post', $book_id) || wp_is_post_revision($book_id) ) return;

    $metadata = isset($_POST['_book_metadata']) ? $this->sanitize($_POST['_book_metadata']) : [];

    update_post_meta($book_id, '_book_metadata', $metadata, $this->data['values']);
  }
}
