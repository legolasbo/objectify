<?php
/**
 * @file
 * FormBuilderInterface definition.
 */

namespace Drupal\objectify_form\Form;

/**
 * Interface FormBuilderInterface
 * @package Drupal\objectify\Form
 */
interface FormBuilderInterface {

  /**
   * The ID of the form.
   *
   * This is required in order to expose the form to the procedural form alter
   * hooks, as you cannot use a class name in a function definition.
   *
   * @return string
   */
  public static function formId();

  /**
   * Build the form.
   *
   * @param $form
   * @param $form_state
   */
  public function buildForm(&$form, &$form_state);

}
