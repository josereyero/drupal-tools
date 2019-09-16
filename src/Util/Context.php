<?php

namespace Reyero\DrupalTools\Util;

/**
 * Provides some contextual values that should work for web an SAPI requests.
 */
class Context {

  /**
   * Gets host name.
   *
   * @return string
   */
  public static function getDrupalRoot() {
    if (defined('DRUPAL_ROOT')) {
      return DRUPAL_ROOT;
    }
    elseif (static::isDrush()) {
      return \Drush\Drush::aliasManager()->getSelf()->root();
    }
  }

  /**
   * Gets host name.
   *
   * @return string
   */
  public static function getProjectRoot() {
    if (defined('DRUPAL_ROOT')) {
      return dirname(DRUPAL_ROOT);
    }
    elseif (static::isDrush()) {
      return \Drush\Drush::bootstrapManager()->getRoot();
    }
  }

  /**
   * Gets host name.
   *
   * @return string
   */
  public static function getHostName() {
    if (!empty($_SERVER['HTTP_HOST'])) {
      return $_SERVER['HTTP_HOST'];
    }
    elseif ($uri = static::getRequestUri()) {
      return parse_url($uri, PHP_URL_HOST);
    }
  }

  /**
   * Gets request URI.
   *
   * @return string
   */
  public static function getRequesUri() {
    if (!empty($_SERVER['REQUEST_URI'])) {
      return $_SERVER['REQUEST_URI'];
    }
    // Drush 9: $_SERVER has no HTTP_HOST key.
    // Fix it to get proper environment settings.
    elseif (static::isDrush()) {
      return \Drush\Drush::bootstrapManager()->getUri();
    }
  }

  /**
   * Check whether this is a Drush request.
   *
   * @return boolean
   */
  public static function isDrush() {
    return PHP_SAPI === 'cli' && defined('DRUSH_MAJOR_VERSION');
  }
}