<?php

namespace Drupal\objectify\Translation;

/**
 * Class Translate
 * @package Drupal\objectify
 */
class Translation implements StringTranslationInterface {

  /**
   * {@inheritdoc}
   */
  public function translate($string, array $args = [], array $options = []) {
    return t($string, $args, $options);
  }

}
