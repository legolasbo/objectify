<?php

namespace Drupal\droop_test\Controller;

use Drupal\droop\StringTranslationTrait;
use Drupal\droop\Translation\StringTranslationInterface;
use Drupal\droop_di\PluginDefinesDependenciesInterface;
use Drupal\droop_menu\Controller\MenuRouteControllerInterface;
use Drupal\droop_menu\MenuRoute;
use Drupal\droop_menu\MenuRouteModel;

class TestController implements MenuRouteControllerInterface, PluginDefinesDependenciesInterface {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public static function dependencies() {
    return [
      '@system.translation',
    ];
  }

  /**
   * TestController constructor.
   *
   * @param StringTranslationInterface $translation
   */
  public function __construct(StringTranslationInterface $translation) {
    $this->translation = $translation;
  }

  /**
   * {@inheritdoc}
   */
  public function getPermissions() {
    return [
      'test permission' => [
        'title' => $this->t('An example test permission.'),
        'description' => $this->t('This is an example test permission, plugged in via the menu component of droop.'),
      ]
    ];
  }

  public function getRoutes() {
    $routes = [];

    $routes['test-path'] = (new MenuRoute())
      ->setTitle('A test title')
      ->setAction($this, 'testAction')
      ->setAccessCallback(TRUE);

    $routes['altered-test-path'] = (new MenuRoute())
      ->setTitle('A test title')
      ->setAction($this, 'testAction')
      ->setAccessCallback(TRUE);

    return $routes;
  }

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(MenuRouteModel $routes) {
    $routes->alterRoute('altered-test-path')
      ->setAccessCallback('user_access')
      ->setAccessArguments(['test permission']);
  }

  /**
   * Test controller action route.
   *
   * @return string
   */
  public function testAction() {
    return $this->t('Hello world!');
  }

}
