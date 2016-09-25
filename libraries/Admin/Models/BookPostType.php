<?php namespace Pho\Admin\Models;
/**
 * BookPostType
 */
final class BookPostType extends AdminModel
{
  /**
   * Constructor
   */
  function __construct()
  {
  	$labels = [
  		'name'                  => _x('Books', 'Post Type General Name', 'pho'),
  		'singular_name'         => _x('Book', 'Post Type Singular Name', 'pho'),
  		'archives'              => __('Book Archives', 'pho'),
  		'all_items'             => __('All Books', 'pho'),
  		'add_new_item'          => __('Add New Book', 'pho'),
  		'new_item'              => __('New Book', 'pho'),
  		'edit_item'             => __('Edit Book', 'pho'),
  		'update_item'           => __('Update Book', 'pho'),
  		'view_item'             => __('View Book', 'pho'),
  		'search_items'          => __('Search Book', 'pho'),
  		'featured_image'        => __('Book cover', 'pho'),
  		'set_featured_image'    => __('Set book cover', 'pho'),
  		'remove_featured_image' => __('Remove book cover', 'pho'),
  		'use_featured_image'    => __('Use as book cover', 'pho'),
  		'insert_into_item'      => __('Insert into book', 'pho'),
  		'uploaded_to_this_item' => __('Uploaded to this book', 'pho')
  	];

  	$args = [
  		'label'             => __('Book', 'pho'),
  		'description'       => __('Book is love, book is life.', 'pho'),
  		'labels'            => $labels,
  		'supports'          => ['title', 'editor', 'excerpt', 'thumbnail', 'comments'],
  		'taxonomies'        => ['post_tag', 'book_genre'],
  		'public'            => true,
      'has_archive'       => true,
  		'menu_position'     => 5,
  		'menu_icon'         => 'dashicons-book-alt',
  		'show_in_nav_menus' => false,
      'show_in_rest'      => true
  	];

    $this->data = [
      'type' => 'book',
      'args' => $args
    ];
  }
}
