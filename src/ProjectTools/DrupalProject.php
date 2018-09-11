<?php

namespace Reyero\DrupalTools\ProjectTools;

/**
 * Wraps project settings
 */
class DrupalProject {

  /**
   * The project id
   *
   * @var string
   */
  protected $id;

  /**
   * The project label.
   *
   * @var string
   */
  protected $project_label;

  /**
   * List of master modules.
   *
   * @var array
   */
  protected $master_modules;

  /**
   * List of features bundles
   *
   * @var array
   */
  protected $features_bundles;

  /**
   * Base directory (project root, absolute path)
   *
   * @var string
   */
  protected $project_base_dir;

  /**
   * Backups directory (project root, absolute path)
   *
   * @var string
   */
  protected $backup_directory;

  /**
   * Ansible configuration
   *
   * Base ansible directory.
   *
   * @var string
   */
  protected $ansible_directory;

  /**
   * Ansible playbooks, indexed by operation/type.
   *
   * Example: [
   *  'checkout' => 'checkout.yml',
   *  'deploy' => 'deploy.yml',
   * ]
   *
   * @var array
   */
  protected $ansible_playbooks;

  /**
   * Object constructor.
   */
  public function __construct($id, $settings) {
    $this->id = $id;

    foreach ($settings as $name => $value) {
      $this->$name = $value;
    }
  }


  /**
   * Gets project id.
   *
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Gets project label.
   *
   * @return string
   */
  public function getLabel() {
    return $this->project_label;
  }

  /**
   * Gets master modules.
   *
   * @return array
   */
  public function getMasterModules() {
    return $this->master_modules;
  }

  /**
   * Gets all settings as array
   */
  public function toArray() {
    return get_object_vars($this);
  }

}