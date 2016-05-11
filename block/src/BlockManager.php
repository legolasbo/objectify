<?php
/**
 * @file
 * BlockManager class implementation.
 */

namespace Drupal\objectify_block;

use Drupal\objectify\DrupalSystem\DrupalSystemInterface;
use Drupal\objectify_block\Exception\NonExistentBlockPluginException;
use Drupal\objectify_block\Plugin\Block\BlockInterface;

/**
 * Class BlockManager
 * @package Drupal\objectify_block
 */
class BlockManager {

  /**
   * Block plugin loader service.
   *
   * @var BlockPluginLoader
   */
  protected $blockPluginLoader;

  /**
   * Drupal system.
   *
   * @var DrupalSystemInterface
   */
  protected $system;

  /**
   * Internal block cache.
   *
   * @var array
   */
  protected $blockCache = [];

  /**
   * BlockManager constructor.
   *
   * @param BlockPluginLoader $block_plugin_loader
   * @param DrupalSystemInterface $system
   */
  public function __construct(BlockPluginLoader $block_plugin_loader,
                              DrupalSystemInterface $system) {
    $this->blockPluginLoader = $block_plugin_loader;
    $this->system = $system;
  }

  /**
   * Get a the block infos that require automatically plugging into Drupal.
   *
   * @return array
   */
  public function getBlockInfos() {
    $blocks = [];
    foreach ($this->blockPluginLoader->getPlugins() as $delta => $plugin) {
      $blocks[$delta] = $plugin->getBlockInfo();
    }
    return $blocks;
  }

  /**
   * Alter a block view to attach plugin build result.
   *
   * @param array $array
   * @param object $block
   */
  public function blockViewAlter(array &$array, $block) {
    try {
      $plugin = $this->blockPluginLoader->getPlugin($block);
    }
    catch (NonExistentBlockPluginException $e) {
      // Ignore exception, a plugin does not exist for this block.
      return;
    }

    if (isset($this->blockCache[$block->module][$block->delta])) {
      $array['content'] = $this->blockCache[$block->module][$block->delta];
    }
    elseif ($build = $plugin->build()) {
      $this->blockCache[$block->module][$block->delta] = $build;
      $array['content'] = $build;
    }

    // Call real block_view_MODULE_DELTA_alter().
    $this->executeAlterHook('block_view', $block, $plugin, $array['content']);
  }

  /**
   * Alter block administration configuration form.
   *
   * Manipulate the block_admin_configure form in order to add the configuration
   * form specified on the block.
   *
   * @param array $form
   * @param array $form_state
   */
  public function formBlockAdminConfigureAlter(array &$form, array &$form_state) {
    if (!isset($form['module']['#value']) || !isset($form['delta']['#value'])) {
      return;
    }

    $block = $this->system->callFunction('block_load', [$form['module']['#value'], $form['delta']['#value']]);
    if (!$block) {
      return;
    }

    try {
      $plugin = $this->blockPluginLoader->getPlugin($block);
    }
    catch (NonExistentBlockPluginException $e) {
      // Ignore exception, a plugin does not exist for this block.
      return;
    }

    $form['settings'] = $plugin->configureForm($form['settings'], $form_state);
    $form['#submit'][] = [$plugin, 'configureFormSubmit'];
    $this->executeAlterHook('block_configure', $block, $plugin, $form['settings'], $form_state);
  }

  /**
   * Expose 
   *
   * @param $hook
   * @param \stdClass $block
   * @param BlockInterface $plugin
   * @param mixed $context
   */
  protected function executeAlterHook($hook, \stdClass $block, BlockInterface $plugin, &$context, &$context2 = NULL, &$context3 = NULL) {
    $module = $block->module;
    $delta = $block->delta;
    $this->getRealBlockModuleAndDelta($module, $delta);

    $args = ["{$hook}_{$module}_{$delta}", &$context, &$context2, &$context3, $plugin];
    return call_user_func_array([$this->system, 'drupalAlter'], array_filter($args));
  }

  /**
   * Load a block from Drupal block API.
   *
   * @param string $module
   * @param string $delta
   *
   * @see block_load()
   *
   * @return \stdClass|NULL
   */
  public function loadBlock($module, $delta) {
    return $this->system->callFunction('block_load', [$module, $delta]);
  }

  /**
   * Work around for block ownership quirk when using BlockAutoPluginInterface.
   *
   * @see BlockAutoPluginInterface
   *
   * @param string $module
   * @param string $delta
   */
  protected function getRealBlockModuleAndDelta(&$module, &$delta) {
    if ($module === 'objectify_block' && strpos($delta, '.') !== FALSE) {
      list($module, $delta) = explode('.', $delta);
    }
  }

  /**
   * Get a renderable array for a block.
   *
   * @param string $module
   *   Implementing module.
   * @param string $delta
   *   Block delta.
   *
   * @return array
   *   Renderable array for block.
   */
  public function getRenderableBlock($module, $delta) {
    $block = $this->loadBlock($module, $delta);
    if (!$block) {
      return [];
    }

    return _block_get_renderable_array(_block_render_blocks([$block]));
  }

}
