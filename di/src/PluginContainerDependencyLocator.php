<?php
/**
 * @file
 * PluginContainerDependencyLocator implementation.
 */

namespace Drupal\droop_di;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class PluginContainerDependencyLocator
 * @package Drupal\droop
 */
class PluginContainerDependencyLocator implements PluginContainerDependencyLocatorInterface {

  /**
   * {@inheritdoc}
   */
  public function initialiseInstanceOfClassByLocatingDependencies(\ReflectionClass $class,
                                                                  ContainerBuilder $container,
                                                                  array &$args = []) {
    if ($class->implementsInterface('Drupal\\droop\\PluginDefinesDependenciesInterface')) {
      $dependencies = call_user_func([$class->getName(), 'dependencies']);
      $args = array_merge($args, $this->resolveDependencies($container, $dependencies));
    }
    elseif ($class->hasMethod('__construct')) {
      // Pass the container itself anyway to allow the plugin to call services.
      // If there is no value in injecting dependencies directly, then
      // requesting them from the container JIT will have performance value,
      // while still allowing the code to be testable.
      $args[] = $container;
    }

    return $class->newInstanceArgs($args);
  }

  /**
   * Resolve dependencies in a list of arguments.
   *
   * @param ContainerBuilder $container
   * @param array $arguments
   *
   * @return mixed
   */
  protected function resolveDependencies(ContainerBuilder $container, array $arguments) {
    $parameterBag = $container->getParameterBag();

    $arguments = $parameterBag->unescapeValue($parameterBag->resolveValue($arguments));
    $arguments = $this->resolveDependencyPlaceholders($arguments);
    return $container->resolveServices($arguments);
  }

  /**
   * Resolves services.
   *
   * @param string|array $value
   *
   * @return array|string|Reference
   */
  protected function resolveDependencyPlaceholders($value) {
    if (is_array($value)) {
      $value = array_map([$this, 'resolveDependencyPlaceholders'], $value);
    }
    elseif (is_string($value) &&  0 === strpos($value, '@')) {
      if (0 === strpos($value, '@@')) {
        $value = substr($value, 1);
        $invalidBehavior = null;
      }
      elseif (0 === strpos($value, '@?')) {
        $value = substr($value, 2);
        $invalidBehavior = ContainerBuilder::IGNORE_ON_INVALID_REFERENCE;
      }
      else {
        $value = substr($value, 1);
        $invalidBehavior = ContainerBuilder::EXCEPTION_ON_INVALID_REFERENCE;
      }

      if ('=' === substr($value, -1)) {
        $value = substr($value, 0, -1);
        $strict = false;
      }
      else {
        $strict = true;
      }

      if (null !== $invalidBehavior) {
        $value = new Reference($value, $invalidBehavior, $strict);
      }
    }

    return $value;
  }

}
