<?php namespace Pho\Publik\Views;
/**
 * PublicView
 */
use Banhmi\Views\AbstractView;

abstract class PublicView extends AbstractView
{
  /**
   * Theme container
   *
   * A service provider which provides settings and registered services.
   *
   * @var  object
   */
  protected $theme;

  /**
   * Constructor
   */
  function __construct(\Pho $theme)
  {
    $this->theme = $theme;
  }
}
