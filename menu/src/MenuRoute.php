<?php
/**
 * @file
 * MenuRoute implementation.
 */

namespace Drupal\objectify_menu;

use Drupal\objectify_menu\Controller\MenuRouteControllerInterface;

/**
 * Class MenuRoute
 * @package Drupal\objectify_menu
 */
class MenuRoute {

  /**
   * Menu route.
   *
   * @var array
   */
  protected $route = [];

  /**
   * Page OO actions arguments array.
   *
   * Contains routing information.
   *
   * @var MenuRouteForwarder
   */
  protected $pageRouteForwarding = [];

  /**
   * Page OO actions arguments array.
   *
   * Contains routing information.
   *
   * @var MenuRouteForwarder
   */
  protected $accessRouteForwarding = [];

  /**
   * MenuRoute constructor.
   *
   * @param array $route
   *   A menu route item.
   */
  public function __construct(array &$route = []) {
    $this->route = &$route;

    if (!empty($this->route['page arguments'])) {
      $first = $this->route['page arguments'];
      if ($first instanceof MenuRouteForwarder) {
        $this->pageRouteForwarding = $first;
      }
    }

    if (!empty($this->route['access arguments'])) {
      $first = $this->route['access arguments'];
      if ($first instanceof MenuRouteForwarder) {
        $this->accessRouteForwarding = $first;
      }
    }
  }

  /**
   * Clone method.
   *
   * Change reference of internal route array to new array.
   *
   * @return MenuRoute
   */
  public function __clone() {
    $route = $this->route;
    $this->route = &$route;
  }

  /**
   * Get the menu item route.
   *
   * @return array
   */
  public function getMenuItem() {
    return $this->route;
  }

  /**
   * Set the callback for this route to be an object method.
   *
   * @param MenuRouteControllerInterface $object
   * @param string $method
   *
   * @return MenuRoute
   */
  public function setAction(MenuRouteControllerInterface $object, $method) {
    $this->route['page callback'] = 'objectify_menu__menu_router';
    $arguments = $this->getPageArguments();
    $this->pageRouteForwarding = new MenuRouteForwarder($object, $method);
    $this->setPageArguments($arguments);
    return $this;
  }

  /**
   * Remove route forwarding for page.
   */
  public function removeAction() {
    $this->pageRouteForwarding = NULL;
    $this->setPageArguments($this->getPageArguments());
  }

  /**
   * Set the callback for this route to be an object method.
   *
   * @param MenuRouteControllerInterface $object
   * @param string $method
   *
   * @return MenuRoute
   */
  public function setAccessAction(MenuRouteControllerInterface $object, $method) {
    $this->route['access callback'] = 'objectify_menu__menu_router';
    $arguments = $this->getPageArguments();
    $this->accessRouteForwarding = new MenuRouteForwarder($object, $method);
    $this->setAccessArguments($arguments);
    return $this;
  }

  /**
   * Remove route forwarding for access.
   */
  public function removeAccessAction() {
    $this->accessRouteForwarding = NULL;
    $this->setAccessArguments($this->getAccessArguments());
  }

  /**
   * Add a page argument.
   *
   * @param mixed $argument
   */
  public function prependPageArgument($argument) {
    $arguments = $this->getPageArguments();
    array_unshift($arguments, $argument);
    $this->setPageArguments($arguments);
  }

  /**
   * Add a page argument.
   *
   * @param mixed $argument
   */
  public function addPageArgument($argument) {
    $arguments = $this->getPageArguments();
    $arguments[] = $argument;
    $this->setPageArguments($arguments);
  }

  /**
   * Getter for title.
   *
   * @return string
   */
  public function getTitle() {
    return $this->get('title');
  }

  /**
   * Getter for title callback.
   *
   * @return string
   */
  public function getTitleCallback() {
    return $this->get('title callback');
  }

  /**
   * Getter for title arguments.
   *
   * @return array
   */
  public function getTitleArguments() {
    return $this->get('title arguments');
  }

  /**
   * Getter for page callback.
   *
   * @return string
   */
  public function getPageCallback() {
    return $this->get('page callback');
  }

  /**
   * Getter for page arguments.
   *
   * @return array
   */
  public function getPageArguments() {
    $arguments = $this->get('page arguments');
    if ($arguments && $this->pageRouteForwarding) {
      $arguments = array_slice($arguments, 1);
    }
    return $arguments ?: [];
  }

  /**
   * Getter for description.
   *
   * @return string
   */
  public function getDescription() {
    return $this->get('description');
  }

  /**
   * @return mixed
   */
  public function getDeliveryCallback() {
    return $this->get('delivery callback');
  }

  /**
   * Getter for access callback.
   *
   * @return string
   */
  public function getAccessCallback() {
    return $this->get('access callback');
  }

  /**
   * Getter for access arguments.
   *
   * @return array
   */
  public function getAccessArguments() {
    $arguments = $this->get('access arguments');
    if ($arguments && $this->accessRouteForwarding) {
      $arguments = array_slice($arguments, 1);
    }
    return $arguments ?: [];
  }

  /**
   * Getter for theme callback.
   *
   * @return string
   */
  public function getThemeCallback() {
    return $this->get('theme callback');
  }

  /**
   * Getter for theme arguments.
   *
   * @return array
   */
  public function getThemeArguments() {
    return $this->get('theme arguments');
  }

  /**
   * Getter for file.
   *
   * @return string
   */
  public function getFile() {
    return $this->get('file');
  }

  /**
   * Getter for file path.
   *
   * @return string
   */
  public function getFilePath() {
    return $this->get('file path');
  }

  /**
   * @return mixed
   */
  public function getLoadArguments() {
    return $this->get('load arguments');
  }

  /**
   * @return mixed
   */
  public function getWeight() {
    return $this->get('weight');
  }

  /**
   * @return mixed
   */
  public function getMenuName() {
    return $this->get('menu_name');
  }

  /**
   * @return mixed
   */
  public function getExpanded() {
    return $this->get('expanded');
  }

  /**
   * @return mixed
   */
  public function getContext() {
    return $this->get('context');
  }

  /**
   * @return mixed
   */
  public function getTabParent() {
    return $this->get('tab_parent');
  }

  /**
   * @return mixed
   */
  public function getTabRoot() {
    return $this->get('tab root');
  }

  /**
   * @return mixed
   */
  public function getPosition() {
    return $this->get('position');
  }

  /**
   * @return mixed
   */
  public function getType() {
    return $this->get('type');
  }

  /**
   * @return mixed
   */
  public function getOptions() {
    return $this->get('options');
  }

  /**
   * Internal getter for array elements.
   *
   * @param string $key
   *
   * @return mixed|null
   */
  protected function get($key) {
    return isset($this->route[$key]) ? $this->route[$key] : NULL;
  }

  /**
   * Setter for title.
   *
   * @param string $title
   *
   * @return $this
   */
  public function setTitle($title) {
    $this->route['title'] = $title;
    return $this;
  }

  /**
   * @param mixed $title_callback
   *
   * @return MenuRoute
   */
  public function setTitleCallback($title_callback) {
    $this->route['title callback'] = $title_callback;
    return $this;
  }

  /**
   * @param mixed $title_arguments
   *
   * @return MenuRoute
   */
  public function setTitleArguments($title_arguments) {
    $this->route['title arguments'] = $title_arguments;
    return $this;
  }

  /**
   * @param mixed $page_callback
   *
   * @return MenuRoute
   */
  public function setPageCallback($page_callback) {
    $this->removeAction();
    $this->route['page callback'] = $page_callback;
    return $this;
  }

  /**
   * Setter for page arguments.
   *
   * @param array $page_arguments
   *
   * @return MenuRoute
   */
  public function setPageArguments(array $page_arguments) {
    if ($this->pageRouteForwarding) {
      $this->route['page arguments'] = array_merge([$this->pageRouteForwarding], $page_arguments);
    }
    else {
      $this->route['page arguments'] = $page_arguments;
    }
    return $this;
  }

  /**
   * @param mixed $description
   *
   * @return MenuRoute
   */
  public function setDescription($description) {
    $this->route['description'] = $description;
    return $this;
  }

  /**
   * @param mixed $delivery_callback
   *
   * @return MenuRoute
   */
  public function setDeliveryCallback($delivery_callback) {
    $this->route['delivery callback'] = $delivery_callback;
    return $this;
  }

  /**
   * @param mixed $access_callback
   *
   * @return MenuRoute
   */
  public function setAccessCallback($access_callback) {
    $this->removeAccessAction();
    $this->route['access callback'] = $access_callback;
    return $this;
  }

  /**
   * Setter for access arguments.
   *
   * @param mixed $access_arguments
   *
   * @return MenuRoute
   */
  public function setAccessArguments($access_arguments) {
    if ($this->accessRouteForwarding) {
      $this->route['access arguments'] = array_merge([$this->accessRouteForwarding], $access_arguments);
    }
    else {
      $this->route['access arguments'] = $access_arguments;
    }
    return $this;
  }

  /**
   * @param mixed $theme_callback
   *
   * @return MenuRoute
   */
  public function setThemeCallback($theme_callback) {
    $this->route['theme callback'] = $theme_callback;
    return $this;
  }

  /**
   * @param mixed $theme_arguments
   *
   * @return MenuRoute
   */
  public function setThemeArguments($theme_arguments) {
    $this->route['theme arguments'] = $theme_arguments;
    return $this;
  }

  /**
   * Setter for file.
   *
   * @param string $file
   *
   * @return $this
   */
  public function setFile($file) {
    $this->route['file'] = $file;
    return $this;
  }

  /**
   * Setter for file path.
   *
   * @param string $file
   *
   * @return $this
   */
  public function setFilePath($file) {
    $this->route['file path'] = $file;
    return $this;
  }

  /**
   * @param mixed $load_arguments
   *
   * @return MenuRoute
   */
  public function setLoadArguments($load_arguments) {
    $this->route['load arguments'] = $load_arguments;
    return $this;
  }

  /**
   * @param mixed $weight
   *
   * @return MenuRoute
   */
  public function setWeight($weight) {
    $this->route['weight'] = $weight;
    return $this;
  }

  /**
   * @param mixed $menu_name
   *
   * @return MenuRoute
   */
  public function setMenuName($menu_name) {
    $this->route['menu_name'] = $menu_name;
    return $this;
  }

  /**
   * @param mixed $expanded
   *
   * @return MenuRoute
   */
  public function setExpanded($expanded) {
    $this->route['expanded'] = $expanded;
    return $this;
  }

  /**
   * @param mixed $context
   *
   * @return MenuRoute
   */
  public function setContext($context) {
    $this->route['context'] = $context;
    return $this;
  }

  /**
   * @param mixed $tab_parent
   *
   * @return MenuRoute
   */
  public function setTabParent($tab_parent) {
    $this->route['tab parent'] = $tab_parent;
    return $this;
  }

  /**
   * @param mixed $tab_root
   *
   * @return MenuRoute
   */
  public function setTabRoot($tab_root) {
    $this->route['tab root'] = $tab_root;
    return $this;
  }

  /**
   * @param mixed $position
   *
   * @return MenuRoute
   */
  public function setPosition($position) {
    $this->route['position'] = $position;
    return $this;
  }

  /**
   * @param mixed $type
   *
   * @return MenuRoute
   */
  public function setType($type) {
    $this->route['type'] = $type;
    return $this;
  }

  /**
   * @param mixed $options
   *
   * @return MenuRoute
   */
  public function setOptions($options) {
    $this->route['options'] = $options;
    return $this;
  }

}
