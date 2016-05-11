<?php
/**
 * @file
 * A logger implementation.
 */

namespace Drupal\objectify\Logger;

/**
 * Class Logger
 * @package Drupal\objectify
 */
class WatchDog implements LoggerInterface {

  /**
   * Name of the module to log to watchdog on behalf of.
   *
   * @var string
   */
  protected $module;

  /**
   * Logger constructor.
   *
   * @param string $module
   */
  public function __construct($module = 'objectify') {
    $this->module = $module;
  }

  /**
   * @see LoggerInterface::log()
   */
  public function log($message, $params = [], $type = WATCHDOG_ERROR) {
    watchdog($this->module, $message, $params, $type);
  }

  /**
   * Getter for $module.
   *
   * @return string
   */
  public function getModule() {
    return $this->module;
  }

  /**
   * Setter for $module.
   *
   * @param string $module
   */
  public function setModule($module) {
    $this->module = $module;
  }

}
