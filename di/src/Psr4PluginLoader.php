<?php
/**
 * @file
 * A PSR-4 compliant plugin loader implementation.
 */

namespace Drupal\objectify_di;

/**
 * Class PluginLoader
 * @package Drupal\objectify_di
 */
abstract class Psr4PluginLoader implements PluginLoaderInterface {

  /**
   * Interface to load plugins for.
   *
   * @var string
   */
  protected $interface;

  /**
   * Namespace to load plugins from.
   *
   * @var string
   */
  protected $namespace;

  /**
   * Internal plugin storage.
   *
   * @var array
   */
  protected $plugins = [];

  /**
   * PluginLoader constructor.
   */
  public function __construct() {
    if ($this->namespace === NULL) {
      throw new \Exception('Cannot load plugins for NULL namespace.');
    }

    $this->registerClassesForModulesInPsr4Namespace();
  }

  /**
   * Register classes to the plugin loader.
   */
  protected function registerClassesForModulesInPsr4Namespace() {
    $cid = get_class($this) . '::registerClassesForModulesInPsr4Namespace';

    $classes = [];

    if ($cache = cache_get($cid)) {
      $classes = $cache->data;
    }
    else {
      foreach (objectify_di_get_active_extensions_by_weight() as $extension => $type) {
        $path = drupal_get_path($type, $extension) . $this->getPsr4NamespacePath();
        if (!$files = file_scan_directory($path, '/\.php/')) {
          continue;
        }

        // Autoload all plugins.
        foreach ($files as $file) {
          list($file_path, $filename, $class) = array_values((array) $file);
          $class = 'Drupal\\' . $extension . '\\' . $this->namespace . '\\' . $class;

          require_once DRUPAL_ROOT . '/' . $file_path;
          if (!class_exists($class)) {
            continue;
          }

          $classes[$class] = [
            'extension' => $extension,
            'type' => $type,
          ];
        }
      }

      cache_set($cid, $classes);
    }

    foreach ($classes as $class => $data) {
      if (!class_exists($class)) {
        user_error("Registered class {$class} for {$cid} no longer exists.", E_USER_WARNING);
        continue;
      }

      $reflection = new \ReflectionClass($class);
      if (!$reflection->isInstantiable()) {
        continue;
      }

      if (!$this->checkClassImplementsRequiredInterfaces($reflection)) {
        continue;
      }

      $this->registerClass($reflection, $data['extension'], $data['type']);
    }
  }

  /**
   * Check that a class implements the required classes for this plugin loader.
   *
   * @param \ReflectionClass $reflection
   *
   * @return bool
   */
  protected function checkClassImplementsRequiredInterfaces(\ReflectionClass $reflection) {
    if (is_string($this->interface)) {
      return $reflection->implementsInterface($this->interface);
    }
    elseif (is_array($this->interface)) {
      foreach ($this->interface as $interface) {
        if (!$reflection->implementsInterface($interface)) {
          return FALSE;
        }
      }
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Get the path to the PSR-4 compliant classes.
   *
   * @return mixed
   */
  protected function getPsr4NamespacePath() {
    return '/src/' . str_replace('\\', '/', $this->namespace);
  }

}
