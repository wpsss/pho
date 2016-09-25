<?php namespace Pho\Helpers;
/**
 * HtmlAttrs
 */
final class HtmlAttrs
{
  /**
   * Attributes
   *
   * @var  array
   */
  private $attrs;

  /**
   * A filter hook to modify the attribute(s)
   *
   * @var  string
   */
  private $filter;

  /**
   * Constructor
   */
  function __construct(array $attrs, $filter = '')
  {
    $this->attrs = $attrs;
    $this->filter = $filter;
  }

  /**
   * Render
   */
  function __toString()
  {
    $attrs = '';

    if ( empty($this->attrs) ) return;

    if ($this->filter)
      $this->attrs = array_merge( $this->attrs, apply_filters($this->filter, $this->attrs) );

    foreach ($this->attrs as $name => $value) {
      if ($value) {
        $attrs .= ' ' . $name . '="' . $value . '"';
      } else {
        $attrs .= ' ' . $name;
      }
    }

    return $attrs;
  }
}
