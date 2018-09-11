<?php

namespace Reyero\DrupalTools\ProjectTools;

/**
 * Wraps project environment settings
 */
class SiteEnvironment extends DrupalProject {

  /**
   * Site host name.
   *
   * Example: 'test.www.unileon.es'
   *
   * @var string
   */
  protected $host;

  /**
   * Site base URL.
   *
   * Example: 'https://test.www.example.com'
   *
   * @var string
   */
  protected $base_url;

  /**
   * Site Drush alias.
   *
   * Example: '@example-test'
   *
   * @var string
   */
  protected $site_alias;

  /**
   * Deployment strategy.
   *
   * Example: 'ansible',
   *
   * @var string
   */
  protected $deployment_strategy;

  /**
   * Ansible inventory, relative to ansible base dir.
   *
   * Example: 'hosts/example-test',
   *
   * @var string
   */
  protected $ansible_inventory;

  /**
   * Reload source environment.
   *
   * Example: 'staging',
   *
   * @var string
   */
  protected $reload_source;

  /**
   * Environment modules.
   *
   * Example: ['site_example_test'],
   *
   * @var array
   */
  protected $environment_modules;

}