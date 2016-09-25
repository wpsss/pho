<?php
/**
 * Template for displaying content of blog page.
 *
 * @package  Pho\Templates
 */
 
// Site main.
?><main class="site-main" itemscope itemtype="https://schema.org/mainContentOfPage"><?php
  if ( !empty($query->posts) ) {
    $view = $this->services['view']->create('ArchivePost');
    foreach ($query->posts as $post) {
      $view->render($post);
    }
  } else {
    _e('No posts found.', 'pho');
  }
?></main><?php

// Pagination.
$this->services['view']->create('Pagination')->render($query);
