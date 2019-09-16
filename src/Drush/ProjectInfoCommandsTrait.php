<?php

namespace Reyero\DrupalTools\Drush;

use Drush\Drush;
use Consolidation\SiteAlias\SiteAliasManagerAwareTrait;

/**
 * Share some drush command helper methods.
 */
trait ProjectInfoCommandsTrait {

  /**
   * Get Drupal Root path.
   *
   * @return string
   */
  protected function getDrupalRoot() {
    return $this->siteAliasManager()->getSelf()->root();
  }

  /**
   * Get Project root path
   *
   * @return string
   */
  protected function getProjectRoot() {
    return dirname($this->getDrupalRoot());
  }

  /**
   * Get Drupal Root path.
   *
   * @return string
   */
  protected function getScriptsPath() {
    return $this->getProjectRoot() . '/scripts';
  }
}