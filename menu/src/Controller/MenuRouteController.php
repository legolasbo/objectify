<?php
/**
 * @file
 * ConfigurationController implementation.
 */

namespace Drupal\objectify_menu\Controller;

use Drupal\objectify_menu\MenuRoute;
use Drupal\objectify_menu\MenuRouteModel;

/**
 * Class MenuRouteController
 * @package Drupal\objectify_menu\Controller
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
