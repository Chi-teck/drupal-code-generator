<?php

declare(strict_types=1);

namespace Drupal\example\Plugin\Menu;

use Drupal\Core\Menu\MenuLinkDefault;

/**
 * @todo Provide description for this class.
 *
 * @DCG
 * Typically a module-defined menu link relies on
 * \Drupal\Core\Menu\MenuLinkDefault class that builds the link using plugin
 * definitions located in YAML files (MODULE_NAME.links.menu.yml). The purpose
 * of having custom menu link class is to make the link dynamic. Sometimes, the
 * title and the URL of a link should vary based on some context, i.e. user
 * being logged, current page URL, etc. Check out the parent classes for the
 * methods you can override to make the link dynamic.
 *
 * @DCG It is important to supply the link with correct cache metadata.
 * @see self::getCacheContexts()
 * @see self::getCacheTags()
 *
 * @DCG
 * You can apply the class to a link as follows.
 * @code
 * foo.example:
 *   title: Example
 *   route_name: foo.example
 *   menu_name: main
 *   class: \Drupal\foo\Plugin\Menu\FooMenuLink
 * @endcode
 */
final class FooMenuLink extends MenuLinkDefault {

}
