<?php
/**
 * @file
 * ConfigurationController implementation.
 */

namespace Drupal\droop_menu\Controller;

use Drupal\droop_menu\MenuRoute;
use Drupal\droop_menu\MenuRouteModel;

/**
 * Class MenuRouteController
 * @package Drupal\droop_menu\Controller
 */
abstract class MenuRouteController implements MenuRouteControllerInterface {

  /**
   * {@inheritdoc}
   */
  public function getPermissions() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getRoutes() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(MenuRouteModel $routes) {}

  /**
   * Create a new menu route.
   *
   * @param array $route
   *
   * @return MenuRoute
   */
  protected function newMenuRoute(array $route = []) {
    return new MenuRoute($route);
  }

}
