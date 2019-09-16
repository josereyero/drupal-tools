<?php

namespace Reyero\DrupalTools\Settings;

/**
 * Read only settings that are initialized with the class.
 *
 * @ingroup utility
 */
interface SettingsInterface {

  /**
   * Returns a setting.
   *
   * @param string $name
   *   The name of the setting to return.
   * @param mixed $default
   *   (optional) The default value to use if this setting is not set.
   *
   * @return mixed
   *   The value of the setting, the provided default if not set.
   */
  public function get($name, $default = NULL);

  /**
   * Returns all the settins.
   *
   * @return array
   *   All the settings.
   */
  public function getAll();

}
