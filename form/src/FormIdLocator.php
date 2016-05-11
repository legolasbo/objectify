<?php

namespace Drupal\objectify_form;

use Drupal\objectify\DrupalSystem\DrupalSystemInterface;

/**
 * Class FormAlterIdLocator
 * @package Drupal\objectify_form
 */
class FormIdLocator {

  /**
   * Drupal system.
   *
   * @var DrupalSystemInterface
   */
  protected $system;

  /**
   * FormAlterIdLocator constructor.
   *
   * @param DrupalSystemInterface $system
   */
  public function __construct(DrupalSystemInterface $system) {
    $this->system = $system;
  }

  /**
   * Get an array of all form ids applicable to a form id.
   *
   * @param string $form_id
   * @param array $args
   *
   * @return array
   */
  public function locateRootIdForFormId($form_id, $args) {
    $forms = $this->system->moduleInvokeAll('forms', $form_id, $args);
    if (!isset($forms[$form_id]['callback'])) {
      return FALSE;
    }

    return $forms[$form_id]['callback'];
  }

}
