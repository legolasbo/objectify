<?php
/**
 * @file
 * BlockInterface definition.
 *
 * @author Jake Wise <jwise@rippleffect.com>
 */

namespace Drupal\objectify_block\Plugin\Block;

/**
 * Interface BlockInterface
 * @package Drupal\objectify_block\Plugin\Block
 */
interface BlockInterface {

  /**
   * Build the view for the block.
   *
   * @return array
   */
  public function build();

  /**
   * Build the configure form for the block.
   *
   * @return array
   */
  public function configureForm($form, &$form_state);

  /**
   * Submission handler for block configure form.
   */
  public function configureFormSubmit($form, &$form_state);

  /**
   * Getter for configuration of this block.
   *
   * @return array
   */
  public function getConfiguration();

}
