<?php namespace Pho\Admin\Views;
/**
 * SettingsPage
 */
final class SettingsPage extends AdminView
{
  /**
   * Render
   *
   * @param  object  $settings
   */
  function render($settings)
  {
    ?><div class="wrap">
      <ul class="tabs nav-tab-wrapper wp-clearfix">
        <li class="nav-tab tab-active" data-tab-id="#mainSettings"><?= __('Main Settings', 'pho') ?></li>
        <li class="nav-tab" data-tab-id="#extraTab"><?= __('Extra Tab', 'pho') ?></li>
      </ul>
      <form class="form-table" method="post" action="options.php">
        <?php settings_fields($settings->group) ?>
        <table id="mainSettings" class="settings-table">
          <tr>
            <td>
              <label for="<?= $settings->name ?>[breadcrumb_sep]">
                <?= __('Breadcrumb Seperator', 'pho') ?>
              </label>
            </td>
            <td>
              <input type="text" name="<?= $settings->name ?>[breadcrumb_sep]" value="<?= $settings->values['breadcrumb_sep'] ?>">
            </td>
          </tr>
          <tr>
            <td>
              <label for="<?= $settings->name ?>[numeric_paginav]">
                <?= __('Pagination Type', 'pho') ?>
              </label>
            </td>
            <td>
              <select id="paginav-select-box" name="<?= $settings->name ?>[numeric_paginav]">
                <option value="0" <?php selected($settings->values['numeric_paginav'], 0) ?>>
                  <?= __('Text-based pagination', 'pho') ?>
                </option>
                <option value="1" <?php selected($settings->values['numeric_paginav'], 1) ?>>
                  <?= __('Numeric pagination', 'pho') ?>
                </option>
              </select>
            </td>
          </tr>
          <tr id="paginav-mid-size" <?php if (!$settings->values['numeric_paginav']) echo 'style="display:none"' ?>>
            <td>
              <label for="<?= $settings->name ?>[paginav_mid_size]">
                <?= __('Pagination Mid Size', 'pho') ?>
              </label>
            </td>
            <td>
              <input type="number" name="<?= $settings->name ?>[paginav_mid_size]" value="<?= $settings->values['paginav_mid_size'] ?>">
            </td>
          </tr>
          <?php do_settings_fields($settings->group, 'main') ?>
        </table>
        <table id="extraTab" class="settings-table" style="display:none">
          <tr><td><?= __('This is a demo tab, you can add more settings here.', 'pho') ?></td></tr>
          <?php do_settings_fields($settings->group, 'extra') ?>
        </table>
        <?php do_settings_sections($settings->group); submit_button() ?>
      </form>
    </div><?php
  }
}
