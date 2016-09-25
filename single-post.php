<?php
/**
 * Template for displaying content of a single post page.
 *
 * @package  Pho\Templates
 */

// Breadcrumb.
$this->services['view']->create('Breadcrumb')->render($query);

// Site main.
?><main class="site-main" itemscope itemtype="https://schema.org/mainContentOfPage"><?php
  $this->services['view']->create('SinglePost')->render($query->posts[0]);
?></main><?php
// End site main.
