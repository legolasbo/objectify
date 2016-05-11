<?php
/**
 * @file
 * DrupalContainerInterface definition.
 */

namespace Drupal\objectify_di;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\objectify\Breadcrumb;
use Drupal\objectify\Database;
use Drupal\objectify\Logger;
use Drupal\objectify\DrupalSystem;

/**
 * Interface DrupalContainerInterface
 * @package Drupal\objectify
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
