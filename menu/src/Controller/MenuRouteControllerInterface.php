<?php
/**
 * @file
 * MenuRouteControllerInterface definition.
 */

namespace Drupal\droop_menu\Controller;

use Drupal\droop_menu\MenuRouteModel;

/**
 * Interface MenuRouteControllerInterface
 * @package Drupal\droop_menu
 */
interface MenuRouteControllerInterface {

  /**
   * Implements hook_menu().
   */
  public function getRoutes();

  /**
   * Implements hook_permissions().
   */
  public function getPermissions();

  /**
   * Implements hook_menu_alter().
   */
  public function alterRoutes(MenuRouteModel $routes);

}
