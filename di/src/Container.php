<?php
/**
 * @file
 * Dependency injection container, extends Symfony's ContainerBuilder.
 */

namespace Drupal\objectify_di;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class Container
 * @package Drupal\objectify
 */
class Container extends ContainerBuilder implements DrupalContainerInterface {

  /**
   * {@inheritdoc}
   */
  public function drupalSystem() {
    return $this->get('system.drupal');
  }

  /**
   * {@inheritdoc}
   */
  public function defaultLogger() {
    return $this->get('system.logger');
  }

  /**
   * {@inheritdoc}
   */
  public function defaultBreadcrumb() {
    return $this->get('system.breadcrumb');
  }

  /**
   * {@inheritdoc}
   */
  public function getDatabase() {
    return $this->get('system.db');
  }

}