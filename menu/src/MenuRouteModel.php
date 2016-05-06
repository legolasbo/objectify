<?php

namespace Drupal\droop_menu;

use Drupal\droop_menu\MenuRoute;

/**
 * Class MenuRouteModel
 * @package Drupal\droop_menu
 */
class MenuRouteModel {

  /**
   * Menu routes to alter.
   *
   * @var array
   */
  protected $items;

  /**
   * MenuRouteModel constructor.
   *
   * @param array $items
   */
  public function __construct(array &$items = []) {
    $this->items = &$items;
  }

  /**
   * Create a new menu route at a path.
   *
   * @param string $path
   *
   * @return MenuRoute
   */
  public function createRoute($path) {
    if (!$path || !is_string($path)) {
      throw new \InvalidArgumentException("Cannot create path that is empty, or not a string.");
    }

    $this->items[$path] = [];
    $route = new MenuRoute($this->items[$path]);
    return $route;
  }

  /**
   * Alter a menu route.
   *
   * @param string $path
   *
   * @return MenuRoute|null
   */
  public function alterRoute($path) {
    if (!$path || !is_string($path)) {
      throw new \InvalidArgumentException("Cannot alter a path that is empty, or not a string.");
    }

    if (!isset($this->items[$path])) {
      return NULL;
    }

    return new MenuRoute($this->items[$path]);
  }

  /**
   * Remove a menu route.
   *
   * @param string $path
   *
   * @return MenuRouteModel
   */
  public function removeRoute($path) {
    if (!$path || !is_string($path)) {
      throw new \InvalidArgumentException("Cannot remove a path that is empty, or not a string.");
    }

    unset($this->items[$path]);
    return $this;
  }

  /**
   * Add a menu route at a path.
   *
   * @param string $path
   * @param MenuRoute $route
   *
   * @return MenuRoute
   *   A new MenuRoute item that is linked to the items array.
   */
  public function addRoute($path, MenuRoute $route) {
    $this->items[$path] = $route->getMenuItem();
    return new MenuRoute($this->items[$path]);
  }

  /**
   * Getter for $items.
   *
   * @return array
   */
  public function &getItems() {
    return $this->items;
  }

}
