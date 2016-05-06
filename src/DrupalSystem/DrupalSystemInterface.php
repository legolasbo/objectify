<?php
/**
 * @file
 * A system class intended to wrap Drupal system functionality, in order to
 * correctly decouple classes from Drupal.
 */

namespace Drupal\droop\DrupalSystem;

use Drupal\droop\EntityDecorator\UserDecorator;
use Drupal\xautoload\DrupalSystem\DrupalSystemInterface as XautoloadDrupalSystemInterface;

/**
 * Interface SystemInterface
 * @package Drupal\droop
 */
interface DrupalSystemInterface extends XautoloadDrupalSystemInterface {

  /**
   * @see drupal_static()
   */
  public function &drupalStatic($name, $default_value = NULL, $reset = FALSE);

  /**
   * @see drupal_get_path()
   */
  public function drupalGetPath($type, $name);

  /**
   * @see render()
   */
  public function render(&$element);

  /**
   * @see drupal_render()
   */
  public function drupalRender(&$elements);

  /**
   * Get the current logged in User.
   *
   * @return \stdClass
   */
  public function getUser();

  /**
   * Get the global $conf array.
   *
   * @return array
   */
  public function &getConfig();

  /**
   * @see drupal_goto()
   */
  public function drupalGoto($path = '', array $options = [], $http_response_code = 302);

  /**
   * @see drupal_set_message()
   */
  public function drupalSetMessage($message = NULL, $type = 'status', $repeat = TRUE);

  /**
   * @see module_invoke_all()
   */
  public function moduleInvokeAll($hook, $parameter = NULL, $_ = NULL);

  /**
   * @see drupal_alter().
   */
  public function drupalAlter($type, &$data, &$context1 = NULL, &$context2 = NULL, &$context3 = NULL);

  /**
   * @see format_date()
   */
  public function formatDate($timestamp, $type = 'medium', $format = '', $timezone = NULL, $langcode = NULL);

  /**
   * @see drupal_get_breadcrumb()
   */
  public function drupalGetBreadcrumb();

}
