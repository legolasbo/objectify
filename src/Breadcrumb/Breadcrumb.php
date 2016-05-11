<?php
/**
 * @file
 * Breadcrumb object api implementation.
 */

namespace Drupal\objectify\Breadcrumb;

use Drupal\objectify\DrupalSystem\DrupalSystemInterface;

/**
 * Class Breadcrumb
 * @package Drupal\objectify
 */
class Breadcrumb {

  /**
   * Pointer to Drupal breadcrumb static variable.
   *
   * @var array
   */
  protected $breadcrumb;

  /**
   * Factory method to fetch an instance of the Drupal system breadcrumb.
   *
   * @param DrupalSystemInterface $system
   *
   * @return Breadcrumb
   */
  public static function createSystemBreadcrumb(DrupalSystemInterface $system) {
    $breadcrumb = &$system->drupalStatic('drupal_set_breadcrumb');
    if (!isset($breadcrumb)) {
      $breadcrumb = $system->drupalGetBreadcrumb();
    }
    return new Breadcrumb($breadcrumb);
  }

  /**
   * Get a new instance.
   *
   * @return \Drupal\objectify\Breadcrumb\Breadcrumb
   */
  public static function create() {
    return new self();
  }

  /**
   * Breadcrumb constructor.
   *
   * @param array $breadcrumb
   */
  public function __construct(array &$breadcrumb = []) {
    $this->breadcrumb = $breadcrumb;
  }

  /**
   * Add a link to the breadcrumb.
   *
   * @param string $text
   * @param string $path
   * @param array $options
   *
   * @return $this
   */
  public function addLink($text, $path, $options = []) {
    $this->breadcrumb[] = l($text, $path, $options);
    return $this;
  }

  /**
   * Add a link to the start of the breadcrumb.
   *
   * @param string $text
   * @param string $path
   * @param array $options
   *
   * @return $this
   */
  public function addLinkToStart($text, $path, $options = []) {
    array_unshift($this->breadcrumb, l($text, $path, $options));
    return $this;
  }

  /**
   * Clear the current breadcrumb.
   *
   * @return $this
   */
  public function clear() {
    $this->breadcrumb = [];
    return $this;
  }

  /**
   * Set the breadcrumb for the current page.
   *
   * @param array $breadcrumb
   *   Array of links.
   */
  public function set(array $breadcrumb) {
    $this->breadcrumb = $breadcrumb;
  }

  /**
   * Build the renderable array for the breadcrumb.
   *
   * @return array
   */
  public function build() {
    return [
      '#theme' => 'breadcrumb',
      '#breadcrumb'=> $this->breadcrumb,
    ];
  }

}
