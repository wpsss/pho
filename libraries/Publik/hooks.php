<?php
/**
 * Filter queried posts
 *
 * @see  https://developer.wordpress.org/reference/hooks/the_posts/
 */
add_filter('the_posts', function(array $posts, \WP_Query $query)
{
  $query->query_vars['cache_results'] = false;

  foreach ($posts as $key => $value) {
    $posts[$key] = $this->services['posts']->create($value);
  }

  return $posts;
}, PHP_INT_MAX, 2);

/**
 * Filter including template
 *
 * @see  https://developer.wordpress.org/reference/hooks/template_include/
 */
add_filter('template_include', function($template)
{
  $template = basename($template);
  $query = clone $GLOBALS['wp_query'];

  require $this->settings['basedir'] . 'template.php';

  return false; // Abort another including.
}, PHP_INT_MAX);

/**
 * Clean up document head.
 *
 * Comment out what you need.
 */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'wp_resource_hints', 2);
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'rest_output_link_wp_head', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('template_redirect', 'wp_shortlink_header', 11, 0);
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
