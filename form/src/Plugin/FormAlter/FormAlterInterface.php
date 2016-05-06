<?php
/**
 * @file
 * FormAlterInterface definition.
 */

namespace Drupal\droop_form\Plugin\FormAlter;

use Drupal\droop_form\Form\FormBuilderInterface;

/**
 * Interface FormAlterInterface
 * @package Drupal\droop_form\Plugin\FormAlter
 */
interface FormAlterInterface extends FormBuilderInterface {

  /**
   * Get an array of form ids that this form will alter.
   *
   * @return array
   */
  public static function formIds();

}
