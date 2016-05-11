<?php
/**
 * @file
 * DrupalDatabaseWrapperFactory implementation.
 */

namespace Drupal\objectify\Database;

/**
 * Class DrupalDatabaseWrapperFactory
 * @package Drupal\objectify
 */
class DrupalDatabaseWrapperFactory {

  /**
   * Factory method for DrupalDatabaseWrapper.
   *
   * @return DrupalDatabaseWrapper
   */
  public static function newDatabaseWrapper() {
    return new DrupalDatabaseWrapper();
  }

}
