<?php
/**
 * Stylesheets
 *
 * @package  Pho\Assets
 */

// Suffix.
$x = SCRIPT_DEBUG ? '.css' : '.min.css';

// Set default version.
$this->services['css']->default_version = self::VERSION;

// Register app stylesheet.
$this->services['css']->add('app', $this->settings['baseuri'] . 'assets/css/app' . $x);

// Register theme-settings stylesheet.
$this->services['css']->add('theme-settings', $this->settings['baseuri'] . 'assets/css/theme-settings' . $x);
