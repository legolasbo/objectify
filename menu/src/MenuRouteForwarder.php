<?php

namespace Drupal\droop_menu;

/**
 * Class MenuRouteForwarder
 * @package Drupal\droop_menu
 */
class MenuRouteForwarder {

  /**
   * The class of the plugin to forward routes to.
   *
   * @var string
   */
  protected $plugin;

  /**
   * The method, or action to call on the plugin.
   *
   * @var string
   */
  protected $method;

  /**
   * MenuRouteForwarder constructor.
   *
   * @param object|string $plugin
   * @param string $method
   */
  public function __construct($plugin, $method) {
    $this->plugin = is_object($plugin) ? get_class($plugin) : $plugin;
    $this->method = $method;
  }

  /**
   * Getter for $plugin.
   *
   * @return string
   */
  public function getPlugin() {
    return $this->plugin;
  }

  /**
   * Getter for $method.
   *
   * @return string
   */
  public function getMethod() {
    return $this->method;
  }

}
