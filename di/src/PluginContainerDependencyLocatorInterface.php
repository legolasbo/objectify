<?php
/**
 * @file
 * PluginContainerDependencyLocatorInterface definition.
 */

namespace Drupal\droop_di;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Interface PluginContainerDependencyLocatorInterface
 * @package Drupal\droop
 */
interface PluginContainerDependencyLocatorInterface {

  /**
   * Initialise an instance of a reflection class by resolving dependencies.
   *
   * Dependencies are obtained by calling ::dependencies() on the class
   *
   * @param \ReflectionClass $class
   * @param ContainerBuilder $container
   * @param array $args
   *   Array of arguments to pass into the constructor and overload with
   *   dependent services.
   *
   * @return object
   */
  public function initialiseInstanceOfClassByLocatingDependencies(\ReflectionClass $class, ContainerBuilder $container, array &$args = []);

}
