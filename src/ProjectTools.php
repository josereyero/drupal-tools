<?php

namespace Reyero\DrupalTools;

use Reyero\DrupalTools\ProjectTools\ProjectSettings;

/**
 * Project Tools helper for Global settings
 */
class ProjectTools {

  /**
   * Project information.
   *
   * @var \Reyero\DrupalTools\ProjectTools\ProjectSettings
   */
  static $settings;

  /**
   * Current project name.
   *
   * @var string
   */
  static $current_project;

  /**
   * Initialize from root paths.
   *
   * @param string $drupal_root
   *   Absolute path to Drupal root directory.
   *
   * @return \Reyero\DrupalTools\ProjectTools\ProjectSettings
   */
  public static function initFromDrupalRoot($drupal_root = NULL) {
    if (!isset(self::$settings)) {
      $settings_path = $drupal_root . '/sites/settings.project.php';
      static::initFromSettingsPath($settings_path, ['drupal_root' => $drupal_root]);
    }
    return static::getSettings();
  }

  /**
   * Initialize from Drupal settings.
   *
   * Basic assumptions:
   * - The constant DRUPAL_ROOT is already initialized.
   * - The project root is one level below
   *
   * @return \Reyero\DrupalTools\ProjectTools\ProjectSettings
   */
  public static function initFromDrupalSettings() {
    if (!isset(self::$settings)) {
      // First try whether it's beeen initialized in Drush RC
      if ($settings = static::initFromDrushOptions()) {
        return $settings;
      }
      else {
        static::initFromDrupalRoot(DRUPAL_ROOT, $drupal_root);
      }
    }
    return static::getSettings();
  }

  /**
   * Try to initialize from drush options.
   *
   * @return \Reyero\DrupalTools\ProjectTools\ProjectSettings|NULL.
   */
  public static function initFromDrushOptions() {
    if (!isset(self::$settings)) {
      if (PHP_SAPI === 'cli' && function_exists('drush_get_option')) {
        if ($project_settings = drush_get_option('project_settings')) {
          $settings['projects'] = $project_settings;
          $settings['directories'] = drush_get_option('project_directories', array());
          $settings['environments'] = drush_get_option('project_environments', array());
          self::$settings = new ProjectSettings($settings);
          return self::$settings;
        }
      }
    }
    else {
      return static::getSettings();
    }
  }

  /**
   * Initialize settings from file.
   *
   * @param string $settings_path
   *   Absolute path for the settings file.
   * @param array $directories
   *   Additional directories to store.
   *
   * @return \Reyero\DrupalTools\ProjectTools\ProjectSettings
   */
  public static function initFromSettingsPath($settings_path, $directories = array()) {
    if (!isset(self::$settings)) {
      // Require settings.project.php
      require $settings_path;

      self::$settings = new ProjectSettings([
          'projects' => $project_settings,
          'environments' => $project_environments,
          'directories' => $project_directories + $directories,
      ]);
    }
    return static::getSettings();
  }

  /**
   * Gets project settings.
   *
   * @return \Reyero\DrupalTools\ProjectTools\ProjectSettings
   *
   * @throws \Exception
   *   When settings not initialized.
   */
  public static function getSettings() {
    if (isset(self::$settings)) {
      return self::$settings;
    }
    else {
      throw new \Exception("ProjectTools settings not initialized.");
    }
  }

  /**
   * Sets current project.
   */
  public static function setCurrentProject($project_name) {
    self::$current_project = $project_name;
  }

  /**
   * Gets project settings.
   *
   * @return array
   */
  public static function getProject($project_name) {
    if ($project = static::getSettings()->getProjectSettings($project_name)) {
      return $project;
    }
    else {
      throw new \Exception(sprintf("Project not found %s", $project_name));
    }
  }

  /**
   * Gets project environments.
   *
   * @return array
   */
  public static function getProjectEnvironments($project_name) {
    if ($environments = static::getSettings()->getProjectEnvironments($project_name)) {
      return $environments;
    }
    else {
      throw new \Exception(sprintf("Project environments not found for project %s", $project_name));
    }
  }

  /**
   * Gets project settings.
   *
   * @return array
   */
  public static function getEnvironment($project_name, $env_name) {
    if ($settings = static::getSettings()->getEnvironmentSettings($project_name, $env_name)) {
      return $settings;
    }
    else {
      throw new \Exception(sprintf("Project environment not found %s %s ", $project_name, $env_name));
    }
  }

  /**
   * Gets environment name by host.
   *
   * @param string $host_name
   *
   * @param string $project_name
   *
   * @return string
   *   Environment name: 'production', 'testing', 'devel', etc...
   */
  public static function getEnvNameByHost($host_name, $project_name = NULL) {
    $project_list = $project_name ? [$project_name] : array_keys(self::$settings->getProjectEnvironments());
    foreach ($project_list as $project_key) {
      foreach (static::getSettings()->getProjectEnvironments($project_key) as $env_name => $env_info) {
        if (!empty($env_info['host']) && $env_info['host'] == $host_name) {
          return $env_name;
        }
      }
    }
  }

}
