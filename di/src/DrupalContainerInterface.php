<?php
/**
 * @file
 * DrupalContainerInterface definition.
 */

namespace Drupal\droop_di;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\droop\Breadcrumb;
use Drupal\droop\Database;
use Drupal\droop\Logger;
use Drupal\droop\DrupalSystem;

/**
 * Interface DrupalContainerInterface
 * @package Drupal\droop
 */
interface DrupalContainerInterface extends ContainerInterface {

  /**
   * Get the abstracted Drupal system service.
   *
   * @return DrupalSystem\DrupalSystemInterface
   */
  public function drupalSystem();
  /**
   * Get the default Logger service.
   *
   * @return Logger\LoggerInterface
   */
  public function defaultLogger();

  /**
   * Get the system breadcrumb manager.
   *
   * @return Breadcrumb\Breadcrumb
   */
  public function defaultBreadcrumb();

  /**
   * Get a service to represent the database.
   *
   * @return Database\DrupalDatabaseWrapper
   */
  public function getDatabase();

}
