<?php
/**
 * @file
 * PluginDefinesDependenciesInterface definition.
 */

namespace Drupal\droop_di;

/**
 * Interface PluginDefinesDependenciesInterface
 * @package Drupal\droop
 */
interface PluginDefinesDependenciesInterface {

  /**
   * An array of dependencies to inject into this plugin.
   *
   * @return array
   */
  public static function dependencies();

}
