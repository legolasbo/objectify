<?php

namespace Drupal\droop;

use Drupal\droop\Translation\StringTranslationInterface;

/**
 * Class StringTranslationTrait
 * @package Drupal\droop
 */
trait StringTranslationTrait {

  /**
   * Translation service.
   *
   * @var StringTranslationInterface
   */
  protected $translation;

  /**
   * Shorthand $translation->translate().
   *
   * @see StringTranslationInterface::translate()
   */
  public function t($string, array $args = [], array $options = []) {
    return $this->translation->translate($string, $args, $options);
  }

  /**
   * Setter for $translation.
   *
   * @param StringTranslationInterface $translation
   */
  public function setTranslation(StringTranslationInterface $translation) {
    $this->translation = $translation;
  }

}
