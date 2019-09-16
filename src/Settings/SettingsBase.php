<?php

namespace Reyero\DrupalTools\Settings;

use Reyero\DrupalTools\Settings\SettingsInterface;

/**
 * Base class for Settings
 *
 * @ingroup utility
 */
abstract class SettingsBase implements SettingsInterface {

  /**
   * Stored settings.
   *
   * @var array
   */
  protected $settings;

  /**
   * {@inheritdoc}
   */
  public function get($name, $default = NULL) {
    $settings = static::getAll();
    return isset($settings[$name]) ? $settings[$name] : $default;
  }

  /**
   * {@inheritdoc}
   */
  public function getAll() {
    if (!isset($this->settings)) {
      throw new \Exception("Settings are not initialized");
    }
    return $this->settings;
  }

}
