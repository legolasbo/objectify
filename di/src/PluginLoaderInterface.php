<?php
/**
 * @file
 * PluginLoaderInterface definition.
 */

namespace Drupal\droop_di;

/**
 * Interface PluginLoaderInterface
 * @package Drupal\droop_di
 */
interface PluginLoaderInterface {

  /**
   * Retrieve the plugins from the loader.
   *
   * @return object|NULL
   */
  public function getPlugins();

}
