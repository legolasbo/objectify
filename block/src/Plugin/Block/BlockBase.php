<?php
/**
 * @file
 * BaseBlock implementation.
 *
 * @author Jake Wise <jwise@rippleffect.com>
 */

namespace Drupal\objectify_block\Plugin\Block;

use Drupal\objectify\DrupalSystem\DrupalSystemInterface;
use Drupal\objectify\StringTranslationTrait;
use Drupal\objectify\Translation\StringTranslationInterface;
use Drupal\objectify_di\PluginDefinesDependenciesInterface;

/**
 * Class BaseBlock
 * @package Drupal\objectify_block\Plugin\Block
 */
abstract class BlockBase implements BlockInterface, PluginDefinesDependenciesInterface {

  use StringTranslationTrait;

  const STATUS_FIXED = 0;
  const STATUS_ENABLED = 1;
  const STATUS_DISABLED = 2;
  const REGION_NONE = -1;
  const VISIBILITY_NOTLISTED = 0;
  const VISIBILITY_LISTED = 1;

  /**
   * Internal Drupal 7 copy block storage.
   *
   * @var \stdClass
   */
  protected $block;

  /**
   * Configuration for block.
   *
   * @var array
   */
  protected $configuration;

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
   * BlockBase constructor.
   *
   * @param object $block
   * @param DrupalSystemInterface $system
   * @param StringTranslationInterface $translation
   */
  public function __construct($block, DrupalSystemInterface $system, StringTranslationInterface $translation) {
    $this->block = clone $block;
    $this->system = $system;
    $this->translation = $translation;
  }

  /**
   * Getter for configuration of this block.
   *
   * @return array
   */
  public function getConfiguration() {
    if (!isset($this->configuration)) {
      $config = $this->system->variableGet("{$this->block->module}_{$this->block->delta}_config", []);
      $this->configuration = $config;
    }
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function configureForm($form, &$form_state) {
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function configureFormSubmit($form, &$form_state) {
    $edit = $this->system->callFunction('element_children', [&$form['settings']]);
    if (!$edit) {
      return;
    }

    $edit = array_flip($edit);
    unset($edit['title']);

    $values = array_intersect_key($form_state['values'], $edit);
    $this->system->variableSet($this->block->module . '_' . $this->block->delta . '_config', $values);
  }

}
