<?php
/**
 * @file
 * MenuRouteControllerInterface definition.
 */

namespace Drupal\objectify_menu\Controller;

use Drupal\objectify_menu\MenuRoute;
use Drupal\objectify_menu\MenuRouteModel;

/**
 * Interface MenuRouteControllerInterface
 * @package Drupal\objectify_menu
 */
interface MenuRouteControllerInterface {

  /**
   * Return an array of MenuRoute objects, keyed by menu path.
   *
   * @return MenuRoute[].
   */
  public function getRoutes();

  /**
   * Implements hook_permissions().
   */
  public function getPermissions();

  /**
   * Exposes all of the menu routes in a MenuRoute model.
   *
   * Use $routes->alterRoute('some/route') to get a MenuRoute object, which can
   * be manipulated.
   *
   * @see MenuRouteModel
   */
  public function alterRoutes(MenuRouteModel $routes);

}
