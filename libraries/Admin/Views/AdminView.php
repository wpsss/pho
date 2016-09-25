<?php namespace Pho\Admin\Views;
/**
 * AdminView
 */
use Banhmi\Views\AbstractView;

abstract class AdminView extends AbstractView
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
