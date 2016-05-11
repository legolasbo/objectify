<?php

namespace Drupal\objectify_block\Plugin\Block;

/**
 * Interface BlockAutoPluginInterface
 * @package Drupal\objectify_block
 */
interface BlockAutoPluginInterface {

  /**
   * The block info array to plug into Drupal.
   *
   * The reason this interface is currently separate is because using this
   * has a quirk: the block will be owned by objectify_block, instead of the module
   * providing it.
   *
   * @todo work around this without patching the block module.
   *
   * @return array
   */
  public function getBlockInfo();

}
