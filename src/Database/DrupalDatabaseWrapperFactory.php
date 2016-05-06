<?php
/**
 * @file
 * DrupalDatabaseWrapperFactory implementation.
 */

namespace Drupal\droop\Database;

/**
 * Class DrupalDatabaseWrapperFactory
 * @package Drupal\droop
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
