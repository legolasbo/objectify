<?php

namespace Drupal\droop_test\Form;

use Drupal\droop\DrupalSystem\DrupalSystemInterface;
use Drupal\droop\StringTranslationTrait;
use Drupal\droop\Translation\StringTranslationInterface;
use Drupal\droop_di\PluginDefinesDependenciesInterface;
use Drupal\droop_form\Form\FormBase;

/**
 * Class TestForm
 * @package Drupal\droop_test
 */
class TestForm extends FormBase implements PluginDefinesDependenciesInterface {

  use StringTranslationTrait;

  /**
   * Drupal system service.
   *
   * @var DrupalSystemInterface
   */
  protected $system;

  /**
   * {@inheritdoc}
   */
  public static function dependencies() {
    return [
      '@system.drupal',
      '@system.translation',
    ];
  }

  /**
   * TestForm constructor.
   *
   * @param DrupalSystemInterface $system
   * @param StringTranslationInterface $translation
   */
  public function __construct(DrupalSystemInterface $system, StringTranslationInterface $translation) {
    $this->system = $system;
    $this->translation = $translation;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(&$form, &$form_state) {
    $form['test'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit form'),
      '#submit' => [
        [$this, 'submitForm'],
      ]
    ];
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   * @param array $form_state
   */
  public function submitForm(array $form, array &$form_state) {
    $this->system->drupalSetMessage($this->t('This form was submitted successfully.'));
  }

}
