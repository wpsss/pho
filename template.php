<?php
/**
 * Master template
 *
 * Depend on your site structure, create your own one for the best result.
 *
 * @package  Pho\Templates
 */

// Locate head template.
$head = locate_template([
  'part-templates/head-' . $template,
  'part-templates/head.php'
]);

// Locate header template.
$header = locate_template([
  'part-templates/header-' . $template,
  'part-templates/header.php'
]);

// Locate main template.
$main = locate_template([
  'part-templates/main-' . $template,
  'page-templates/' . $template,
  $template
]);

// Locate footer template.
$footer = locate_template([
  'part-templates/footer-' . $template,
  'part-templates/footer.php'
]);

// Enqueue app stylesheet.
$this->services['css']->enqueue('app');

// Enqueue app script.
$this->services['js']->enqueue('app');

// Render document.
?><!DOCTYPE html>
<html lang="<?= $this->settings['language'] ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php include $head; do_action('wp_head') ?>
</head>
<body>
  <header class="site-header" itemscope itemtype="https://schema.org/WPHeader">
    <?php include $header ?>
  </header>
  <?php include $main // Maybe there're sidebars, pagination... ?>
  <footer class="site-footer" itemscope itemtype="https://schema.org/WPFooter">
    <?php include $footer ?>
  </footer>
  <?php do_action('wp_footer') ?>
</body>
</html>
