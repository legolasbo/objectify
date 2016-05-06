<?php

namespace Drupal\droop\Translation;

/**
 * Class Translate
 * @package Drupal\droop
 */
class Translation implements StringTranslationInterface {

  /**
   * {@inheritdoc}
   */
  public function translate($string, array $args = [], array $options = []) {
    return t($string, $args, $options);
  }

}
