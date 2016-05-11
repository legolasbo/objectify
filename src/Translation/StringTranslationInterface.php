<?php

namespace Drupal\objectify\Translation;

/**
 * Interface StringTranslationInterface
 * @package Drupal\objectify
 */
interface StringTranslationInterface {

  /**
   * Translate a string.
   *
   * @param $string
   * @param array $args
   * @param array $options
   *
   * @return string
   */
  public function translate($string, array $args = [], array $options = []);

}
