<?php
/**
 * @file
 * PluginDefinesDependenciesInterface definition.
 */

namespace Drupal\objectify_di;

/**
 * Interface PluginDefinesDependenciesInterface
 * @package Drupal\objectify
 */
interface PluginDefinesDependenciesInterface {

  /**
   * An array of dependencies to inject into this plugin.
   *
   * @return array
   */
  public static function dependencies();

}
