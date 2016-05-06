<?php
/**
 * @file
 * LoggerInterface definition.
 */

namespace Drupal\droop\Logger;

/**
 * Interface LoggerInterface
 * @package Drupal\droop
 */
interface LoggerInterface {

  /**
   * Log an error to a logging service.
   *
   * @param string $message
   * @param array $params
   * @param int $type
   */
  public function log($message, $params = [], $type = 0);

}
