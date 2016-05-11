<?php
/**
 * @file
 * PluginLoaderInterface definition.
 */

namespace Drupal\objectify_di;

/**
 * Interface PluginLoaderInterface
 * @package Drupal\objectify_di
 */
interface PluginLoaderInterface {

  /**
   * Retrieve the plugins from the loader.
   *
   * @return object|NULL
   */
  public function getPlugins();

}
