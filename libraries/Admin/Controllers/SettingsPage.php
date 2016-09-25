<?php namespace Pho\Admin\Controllers;
/**
 * SettingsPage
 */
use Banhmi\Controllers\MenuPage;

final class SettingsPage extends MenuPage
{
  /**
   * Do notification
   *
   * @see  https://developer.wordpress.org/reference/hooks/admin_notices/
   */
  function notify()
  {
    if ($GLOBALS['page_hook'] !== 'toplevel_page_' . $this->model->slug) return;

    if ( isset($_REQUEST['settings-updated']) && 'true' === $_REQUEST['settings-updated'] )
      echo '<div class="updated notice is-dismissible"><p><strong>' . __('Settings have been saved successfully!', 'pho') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . __('Dismiss this notice.') . '</span></div>';

    if ( isset($_REQUEST['error']) && 'true' === $_REQUEST['error'] )
      echo '<div class="updated error is-dismissible"><p><strong>' . __('Failed to save settings. Please try again!', 'pho') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . __('Dismiss this notice.') . '</span></div>';
  }
}
