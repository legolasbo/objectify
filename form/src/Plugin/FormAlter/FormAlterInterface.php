<?php
/**
 * @file
 * FormAlterInterface definition.
 */

namespace Drupal\objectify_form\Plugin\FormAlter;

use Drupal\objectify_form\Form\FormBuilderInterface;

/**
 * Interface FormAlterInterface
 * @package Drupal\objectify_form\Plugin\FormAlter
 */
interface FormAlterInterface extends FormBuilderInterface {

  /**
   * Get an array of form ids that this form will alter.
   *
   * @return array
   */
  public static function formIds();

}
