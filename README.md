#An Object-Oriented API for Drupal 7
This project is a collection of components that I have written over the last year, while working on client projects with Drupal 7. The components have been separated out, allowing them to be used independent of one another. I have looked to move components more inline with the direction that Drupal 8 was moving in, however they are still largely a custom, and 'essentials' abstraction of Drupal 7 array configurations, based on the documentation.

I thought I would share this, even though Drupal 8 would be the go-to version if OO programming was a priority. However, since Drupal 7 will likely be around for a few more years, and there are plenty of Drupal 7 website that have on-going development; I imagine that there are a few developers that will find this useful.

###Requirements

This module requires composer. If you use composer to build your Drupal 7 site, then it should do all the work for you, and makes use of X Autoload to plug in the vendor/composer/autoload.php file, which will allow you to make use of PHP libraries, as well as allowing you to use PSR-4 Drupal 8 style class autoloading in your modules (`mymodule/src/SubNamespace/Class`). It will attempt to locate this file for you, it will look in the directory above `DRUPAL_ROOT`, in `DRUPAL_ROOT` and in the module's folder. If you have a different site structure, then you will need to define the constant `VENDOR_COMPOSER_DIR` in your settings.php file.

If you do not build the site using composer, then you will need to add a line to your build script to run composer install in the module directory, after the site has been built.

##Dependency injection component (objectify_di)

This module depends on the `symfony/dependency-injection` library, which includes `symfony/yaml`. This component will use the `YamlFileLoader` to load container yaml files from each active module (mymodule.services.yml) into either: a default container provided by this module, initialised just-in-time, or a container initialised by yourself and running: `objectify_di_build_container($container)` (recommend using hook_init() for that, although you could use `hook_service_container_to_build_alter()`).

Symfony dependency injection component documentation

Plugins and dependencies
This module provides a base plugin system for other components in this project (such as menu and form), the idea being that when classes are autoloaded and plugged in, they have a way of defining their own dependencies.

I recently noticed that Drupal 8 has a similar way of doing this, which is to hand the container to a static factory method on the class, if the class implemented a particular interface. I wasn't too keen on this; I instead had opted for a YAML style arguments array:
```php
public static function dependencies() {
  return [
    '@example.service',
    '%example.parameter%',
  ];
}
```
Otherwise, you can just add a constructor to your class, and the container will be passed into it as the first argument anyway. This isn't recommended, but would allow you to request a service from the container just-in-time, rather than just-in-case; the Symfony container does support proxy instantiation, which would be the better way to lazy load services.

Any plugin classes need to implement the `Drupal\objectify_di\PluginDefinesDependenciesInterface` interface. You could, however, swap out the `@objectify_di.plugin_dependency_loader` service for your own, using `hook_service_container_alter()`, if you think of a better way of doing it (see `Drupal\objectify_di\PluginContainerDependencyLocatorInterface`).

###Menu component (objectify_menu)

This API provides a plugin mechanism for classes in the Controller sub-namespace of any modules, that implements the interface `Drupal\objectify_menu\Controller\MenuRouteControllerInterface`.

The interesting part here is that when defining routes (see `MenuRouteControllerInterface::getRoutes()`) you can return an array of `MenuRoute` objects, which provides an OO abstraction of the hook_menu() config arrays. You can also do: `$route->setAction($this, 'testAction');` which will actually map that path to the method `testAction()` on the current object. There is also `setAccessAction()` for access callbacks.

###Form component (objectify_form)

The form API provides another plugin mechanism for classes in the Form sub-namespace of any modules, that implement the interface `Drupal\objectify_form\Form\FormBuilderInterface`.

You can get forms by fully-qualified class name: `drupal_get_form('Drupal\mymodule\Form\MyForm')`, and use the DI component to inject your validation services. You can also specify a procedural form ID with `FormBuilderInterface::formId()`, to still allow other modules to use `hook_form_FORM_ID_alter()`.

####Form alter plugins
Forms can be altered with classes in the `Plugin\FormAlter` sub-namespace, that implement `Drupal\objectify_form\Plugin\FormAlter\FormAlterInterface`. Form ids to alter are specified with `FormAlterInterface::formIds()`, and expects an array of form ids, or fully qualified class names of other form builders, that will be altered.

###Block component (objectify_block)
@todo
