<?php
/**
 * @file
 * MenuRoutePluginLoader implementation.
 */

namespace Drupal\objectify_menu;

use Drupal\objectify_di\PluginContainerDependencyLocatorInterface;
use Drupal\objectify_di\Psr4PluginLoader;
use Drupal\objectify_menu\Controller\MenuRouteControllerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MenuRoutePluginLoader
 * @package Drupal\objectify_menu
 */
class MenuRoutePluginLoader extends Psr4PluginLoader {

  /**
   * {@inheritdoc}
   */
  protected $namespace = 'Controller';

  /**
   * {@inheritdoc}
   */
  protected $interface = 'Drupal\\objectify_menu\\Controller\\MenuRouteControllerInterface';

  /**
   * Internal storage for class mappings.
   *
   * @var \ReflectionClass[]
   */
  protected $plugins = [];

  /**
   * Internal storage for initialised plugins.
   *
   * @var MenuRouteControllerInterface[]
   */
  protected $initialised = [];

  /**
   * Whether or not the menu route plugins have been fully initialised.
   *
   * @var bool
   */
  protected $isFullyInitialised = FALSE;

  /**
   * Dependency injection container.
   *
   * @var ContainerBuilder
   */
  protected $container;

  /**
   * Plugin dependency locator.
   *
   * @var PluginContainerDependencyLocatorInterface
   */
  protected $locator;

  /**
   * MenuRoutePluginLoader constructor.
   *
   * @param ContainerBuilder $container
   * @param PluginContainerDependencyLocatorInterface $locator
   */
  public function __construct(ContainerBuilder $container,
                              PluginContainerDependencyLocatorInterface $locator) {
    $this->container = $container;
    $this->locator = $locator;
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public function registerClass(\ReflectionClass $class, $extension, $type) {
    $this->plugins[$class->getName()] = $class;
  }

  /**
   * {@inheritdoc}
   *
   * @return MenuRouteControllerInterface
   */
  public function getPlugin($class) {
    if (isset($this->initialised[$class])) {
      return $this->initialised[$class];
    }

    if (!isset($this->plugins[$class])) {
      throw new \InvalidArgumentException("Requested non-existent plugin {$class}.");
    }

    $this->initialised[$class] = $this->locator->initialiseInstanceOfClassByLocatingDependencies($this->plugins[$class], $this->container);
    return $this->initialised[$class];
  }

  /**
   * Get the plugins for this loader.
   *
   * @return MenuRouteControllerInterface[]
   */
  public function getPlugins() {
    if ($this->isFullyInitialised) {
      return $this->initialised;
    }

    foreach ($this->plugins as $class => $reflection) {
      $this->getPlugin($class);
    }

    $this->isFullyInitialised = TRUE;
    return $this->initialised;
  }

}
