<?php
// Add theme settings page.
$m = new Pho\Admin\Models\SettingsPage($this->settings);
$v = $this->services['view']->create('SettingsPage');
$c = new Pho\Admin\Controllers\SettingsPage($m, $v);
add_action('admin_menu', [$c, 'add']);
add_action('admin_init', [$c, 'register'], 0, 0);
add_action('admin_notices', [$c, 'notify'], 0, 0);

// Enqueue stylesheet and script for theme settings page.
add_action('admin_print_scripts-toplevel_page_' . $m->slug, function()
{
  $this->services['js']->enqueue('theme-settings');
  $this->services['css']->enqueue('theme-settings');
}, 0, 0);

// Add book meta box.
$m = new Pho\Admin\Models\BookMetaBox;
$v = $this->services['view']->create('BookMetaBox');
$c = new Banhmi\Controllers\MetaBox($m, $v);
add_action('save_post_book', [$m, 'save']);
add_action('add_meta_boxes_book', [$c, 'add'], 0, 0);
