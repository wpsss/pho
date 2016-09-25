<?php namespace Pho\Publik\Views;
/**
 * Pagination
 */
final class Pagination extends PublicView
{
  /**
   * Render
   *
   * @param  object  $query  \WP_Query
   */
  function render($query)
  {
    $query->max_num_pages = intval($query->max_num_pages);
    $query->query_vars['paged'] = $query->query_vars['paged'] ? : 1;

    if (1 >= $query->max_num_pages) return;

    ?><div class="entry-pagination"><ul><?php
      $this->thePreviousButton($query);
      if ($this->theme->settings['numeric_paginav']) {
        $this->theNumericPagination($query);
      } else {
        $this->theTextPagination($query);
      }
      $this->theNextButton($query);
    ?></ul></div><?php
  }

  /**
   * The previous button
   */
  private function thePreviousButton(\WP_Query $query)
  {
    if (1 < $query->query_vars['paged']) : ?>
      <li class="prev">
        <a rel="prev" href="<?= get_pagenum_link($query->query_vars['paged'] - 1) ?>">
          <?= '&lang; ' . __('Prev Page', 'pho') ?>
        </a>
      </li>
    <?php endif;
  }

  /**
   * The next button
   */
  private function theNextButton(\WP_Query $query)
  {
    if ($query->max_num_pages > $query->query_vars['paged']) : ?>
      <li class="next">
        <a rel="next" href="<?= get_pagenum_link($query->query_vars['paged'] + 1) ?>">
          <?= __('Next Page', 'pho') . ' &rang;' ?>
        </a>
      </li>
    <?php endif;
  }

  /**
   * The numeric pagination
   *
   * @param  array  $pages  The current page and around pages which will be displayed.
   */
  private function theNumericPagination(\WP_Query $query, $pages = [])
  {
    // Get max number of pages.
    $maxpages = $query->max_num_pages;

    // Get current page.
    $current = $query->query_vars['paged'];

    // Add the first page to the array.
    if (1 === $current) $pages[] = $current;

    // Add current page and around pages to the displaying array.
    if ($this->theme->settings['paginav_mid_size'] <= $current) {
      $pages[] = $current;
      for ($i = 1; $i <= $this->theme->settings['paginav_mid_size']; $i++) {
        if ($current + $i > $maxpages) break;
        $pages[] = $current - $i;
        $pages[] = $current + $i;
      }
    }

    // Make sure the pages are in correct order.
    $pages = array_filter( array_unique($pages) ); sort($pages);

    // Show the first page.
    if ( !in_array(1, $pages) ) :
      $class = (1 === $current) ? ' class="active"' : '';
      ?><li<?= $class ?>>
        <a href="<?= get_pagenum_link(1) ?>" aria-label="<?= __('Go to page', 'pho') ?> 1">1</a>
      </li><?php
      if ( !in_array(2, $pages) ) echo '<li role="presentation">&hellip;</li>';
    endif;

    // Show the current page and around pages.
    foreach ($pages as $page) :
      $class = ($current === $page) ? ' class="active"' : '';
      ?><li<?= $class ?>>
        <a href="<?= get_pagenum_link($page) ?>" aria-label="<?= __('Go to page', 'pho') . ' ' . $page ?>"><?= $page ?></a>
      </li><?php
    endforeach;

    // Show the last page.
    if ( !in_array($maxpages, $pages) ) :
      if ( !in_array($maxpages - 1, $pages) ) echo '<li role="presentation">&hellip;</li>';
      $class = ($current === $maxpages) ? ' class="active"' : '';
      ?><li<?= $class ?>>
        <a href="<?= get_pagenum_link($maxpages) ?>" aria-label="<?= __('Go to page', 'pho') . ' ' . $maxpages ?>"><?= $maxpages ?></a>
      </li><?php
    endif;
  }

  /**
   * The text pagination.
   */
  private function theTextPagination(\WP_Query $query)
  {
    ?><li class="current">
      <?= __('Page', 'pho') . ' ' . $query->query_vars['paged'] . '/' . $query->max_num_pages ?>
    </li><?php
  }
}
