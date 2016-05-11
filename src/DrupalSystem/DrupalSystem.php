<?php
/**
 * @file
 * Drupal system class implementation.
 */

namespace Drupal\objectify\DrupalSystem;

use Drupal\xautoload\DrupalSystem\DrupalSystem as XautoloadDrupalSystem;
use Drupal\objectify\DrupalSystem\DrupalSystemInterface as objectifyDrupalSystemInterface;

/**
 * Class DrupalSystem
 * @package Drupal\objectify
 */
class DrupalSystem extends XautoloadDrupalSystem implements objectifyDrupalSystemInterface {

  /**
   * {@inheritdoc}
   */
  public function &drupalStatic($name, $default_value = NULL, $reset = FALSE) {
    $value = &drupal_static($name, $default_value, $reset);
    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public function drupalGetPath($type, $name) {
    return drupal_get_path($type, $name);
  }

  /**
   * {@inheritdoc}
   */
  public function render(&$element) {
    return render($element);
  }

  /**
   * {@inheritdoc}
   */
  public function drupalRender(&$elements) {
    return drupal_render($elements);
  }

  /**
   * {@inheritdoc}
   */
  public function getUser() {
    global $user;
    return $user;
  }

  /**
   * {@inheritdoc}
   */
  public function &getConfig() {
    global $conf;
    return $conf;
  }

  /**
   * {@inheritdoc}
   */
  public function drupalGoto($path = '', array $options = [], $http_response_code = 302) {
    drupal_goto($path, $options, $http_response_code);
  }

  /**
   * {@inheritdoc}
   */
  public function drupalSetMessage($message = NULL, $type = 'status', $repeat = TRUE) {
    return drupal_set_message($message, $type, $repeat);
  }

  /**
   * {@inheritdoc}
   */
  public function moduleInvokeAll($hook, $parameter = NULL, $_ = NULL) {
    $args = func_get_args();
    return call_user_func_array('module_invoke_all', $args);
  }

  /**
   * {@inheritdoc}
   */
  public function moduleInvoke($module, $hook, $parameter = NULL, $_ = NULL) {
    $args = func_get_args();
    return call_user_func_array('module_invoke', $args);
  }

  /**
   * {@inheritdoc}
   */
  public function drupalAlter($type, &$data, &$context1 = NULL, &$context2 = NULL, &$context3 = NULL) {
    $args = func_get_args();
    array_splice($args, 5);
    return call_user_func_array('drupal_alter', array_merge([$type, &$data, &$context1, &$context2, &$context3], $args));
  }

  /**
   * {@inheritdoc}
   */
  public function formatDate($timestamp, $type = 'medium', $format = '', $timezone = NULL, $langcode = NULL) {
    return format_date($timestamp, $type, $format, $timezone, $langcode);
  }

  /**
   * {@inheritdoc}
   */
  public function drupalGetBreadcrumb() {
    return drupal_get_breadcrumb();
  }

  /**
   * {@inheritdoc}
   */
  public function drupalGetForm($form_id) {
    return drupal_get_form($form_id);
  }

  /**
   * Overridden to prevent accidentally changing the weight of the xautoload
   * module.
   *
   * @see DrupalSystem::installSetModuleWeight()
   */
  public function installSetModuleWeight($weight) {}

  /**
   * {@inheritdoc}
   */
  public function callFunction($func, array $args = []) {
    return call_user_func_array($func, $args);
  }
  
}
