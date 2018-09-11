<?php

namespace Reyero\DrupalTools\ProjectTools;

/**
 * Project Tools helper for Global settings
 *
 * The project settings file must be located in:
 *   DRUPAL_ROOT/sites/settings.project.php
 */
class ProjectSettings {

  /**
   * Project information.
   *
   * @var array
   */
  protected $projects;

  /**
   * Environment information.
   *
   * @var array
   */
  protected $environments;

  /**
   * Directory information.
   *
   * @var array
   */
  protected $directories;

  /**
   * Class constructor.
   *
   * @param array $settings
   */
  public function __construct($settings) {
    foreach ($settings as $name => $value) {
      $this->$name = $value;
    }
  }



  /**
   * Gets project directories.
   *
   * @return array
   */
  public function getDirectories() {
    return $this->directories;
  }

  /**
   * Gets project settings.
   *
   * @param string $project_name
   *
   * @return array
   *   Project settings for the project or all projects if empty
   */
  public function getProjectSettings($project_name = NULL) {
    if ($project_name) {
      return isset($this->projects[$project_name]) ? $this->projects[$project_name] : array();
    }
    else {
      return $this->projects;
    }
  }

  /**
   * Gets project environments.
   *
   * @return array
   */
  public function getProjectEnvironments($project_name = NULL) {
    if ($project_name) {
      return isset($this->environments[$project_name]) ?  $this->environments[$project_name] : array();
    }
    else {
      return $this->environments;
    }
  }

  /**
   * Gets project environment settings.
   *
   * @return array
   *   Env settings for the environment name or all envs for the project if empty.
   */
  public function getEnvironmentSettings($project_name, $env_name) {
    if ($project_settings = $this->getProjectSettings($project_name)) {
      if (isset($this->environments[$project_name][$env_name])) {
        return $this->environments[$project_name][$env_name] + $project_settings;
      }
    }
    // No project / env found, empty response
    return array();

  }

}
