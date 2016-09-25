<?php namespace Pho\Admin\Models;
/**
 * SettingsPage
 */
final class SettingsPage extends AdminModel
{
  /**
   * Constructor
   *
   * @param  array  $settings  Current theme's settings in database.
   */
  function __construct(array $settings)
  {
    $this->data = [
      'slug'       => 'theme-settings',
      'icon'       => 'dashicons-admin-generic',
      'name'       => \Pho::OPTION_NAME,
      'title'      => __('Theme Settings', 'pho'),
      'group'      => 'theme_default_settings',
      'values'     => $settings,
      'position'   => '88.8888888888888888888',
      'capability' => 'administrator'
    ];
  }

  /**
   * Do sanitization
   *
   * @see  https://developer.wordpress.org/reference/hooks/sanitize_option_option/
   *
   * @param  array  $settings  An array of raw settings' values.
   *
   * @return  array  $settings  An array of sanitized settings' values.
   */
  function sanitize($settings)
  {
    $settings['breadcrumb_sep']   = sanitize_text_field($settings['breadcrumb_sep']) ? : '&rang;';
    $settings['numeric_paginav']  = absint($settings['numeric_paginav']) ? : 0;
    $settings['paginav_mid_size'] = absint($settings['paginav_mid_size']) ? : 1;

    return $settings;
  }
}
