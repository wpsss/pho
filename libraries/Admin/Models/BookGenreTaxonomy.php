<?php namespace Pho\Admin\Models;
/**
 * BookGenreTaxonomy
 */
final class BookGenreTaxonomy extends AdminModel
{
  /**
   * Constructor
   */
  function __construct()
  {
  	$labels = [
  		'name'                       => _x('Book Genre', 'Taxonomy General Name', 'pho'),
  		'singular_name'              => _x('Book Genre', 'Taxonomy Singular Name', 'pho'),
  		'all_items'                  => __('All Book Genre', 'pho'),
  		'new_item_name'              => __('New Book Genre Name', 'pho'),
  		'add_new_item'               => __('Add New Book Genre', 'pho'),
  		'edit_item'                  => __('Edit Book Genre', 'pho'),
  		'update_item'                => __('Update Book Genre', 'pho'),
  		'view_item'                  => __('View Book Genre', 'pho'),
  		'popular_items'              => __('Popular Book Genre', 'pho'),
  		'search_items'               => __('Search Book Genre', 'pho'),
  		'separate_items_with_commas' => __('Separate book genres with commas', 'pho')
  	];

  	$args = [
  		'labels'            => $labels,
  		'public'            => true,
      'hierarchical'      => true,
  		'show_in_nav_menus' => false,
  		'rewrite'           => ['slug' => 'book-genre', 'with_front' => true, 'hierarchical' => true],
      'show_in_rest'      => true
  	];

    $this->data = [
      'type'     => 'book',
      'args'     => $args,
      'taxonomy' => 'book_genre'
    ];
  }
}
