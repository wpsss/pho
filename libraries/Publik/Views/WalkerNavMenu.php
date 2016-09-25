<?php namespace Pho\Publik\Views;
/**
 * WalkerNavMenu
 *
 * A simple customized Walker for improving markup and accessibility.
 */
use Pho\Helpers\Html;

final class WalkerNavMenu extends \Walker_Nav_Menu
{
  /**
   * Theme container
   *
   * A service provider which provides settings and registered services.
   *
   * @var  object
   */
  private $theme;

  /**
   * Constructor
   */
  function __construct(\Pho $theme)
  {
    $this->theme = $theme;
  }

  /**
   * Start the element output
   *
   * @see  \Walker_Nav_Menu::start_el()
   */
  function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
  {
    $attrs['class'] = 'menu-item';

    if (0 === $depth && $this->has_children) {
      $attrs['class'] .= ' parent';
      $attrs['aria-haspopup'] = 'true';
    }

    if ( in_array('current-menu-item', (array)$item->classes) ) $attrs['class'] .= ' active';

    $output .= '<li' . Html::attrs($attrs, 'menu_item_attr') . '>';
    $attrs   = $item->classes[0] ? ' class="' . $item->classes[0] . '"' : '';
    $attrs  .= $item->xfn        ? ' rel="' . $item->xfn . '"'          : '';
    $attrs  .= $item->target     ? ' target="' . $item->target . '"'    : '';
    $attrs  .= $item->url        ? ' href="' . $item->url . '"'         : '';
    $output .= $args->before . '<a' . $attrs . ' itemprop="url">' . '<span itemprop="name">' . $item->title . '</span></a>' . $args->after;
  }
}
