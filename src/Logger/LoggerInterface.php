<?php
/**
 * @file
 * LoggerInterface definition.
 */

namespace Drupal\objectify\Logger;

/**
 * Interface LoggerInterface
 * @package Drupal\objectify
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
