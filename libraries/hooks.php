<?php
// Disable XML-RPC service.
add_filter('xmlrpc_enabled', '__return_false', PHP_INT_MAX);

// Remove X-Pingback header.
add_filter('pings_open', '__return_false', PHP_INT_MAX);

// Register book custom post type.
$m = new Pho\Admin\Models\BookPostType;
$c = new Pho\Admin\Controllers\BookPostType($m);
add_filter('init', [$c, 'register'], 10, 0);
add_filter('post_updated_messages', [$c, 'notify']);

// Register book genre taxonomy.
$m = new Pho\Admin\Models\BookGenreTaxonomy;
$c = new Banhmi\Controllers\Taxonomy($m);
add_filter('init', [$c, 'register'], 10, 0);
