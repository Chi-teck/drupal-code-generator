<?php /** @noinspection ALL */

namespace PHPSTORM_META {

  use DrupalCodeGenerator\Helper\Dumper\DumperInterface;

  override(
    \Symfony\Component\Console\Helper\HelperSet::get(0),
    map([
      'service_info' => \DrupalCodeGenerator\Helper\Drupal\ServiceInfo::class,
      'module_info' => \DrupalCodeGenerator\Helper\Drupal\ModuleInfo::class,
      'theme_info' => \DrupalCodeGenerator\Helper\Drupal\ThemeInfo::class,
      'hook_info' => \DrupalCodeGenerator\Helper\Drupal\HookInfo::class,
      'route_info' => \DrupalCodeGenerator\Helper\Drupal\RouteInfo::class,
      'permission_info' => \DrupalCodeGenerator\Helper\Drupal\PermissionInfo::class,
      'config_info' => \DrupalCodeGenerator\Helper\Drupal\ConfigInfo::class,
      'dry_dumper' => \DrupalCodeGenerator\Helper\Dumper\DumperInterface::class,
      'filesytem_dumper' => \DrupalCodeGenerator\Helper\Dumper\DumperInterface::class,
      'renderer' => \DrupalCodeGenerator\Helper\Renderer\RendererInterface::class,
      'question' => \DrupalCodeGenerator\Helper\QuestionHelper::class,
      'assets_table_printer' => \DrupalCodeGenerator\Helper\Printer\PrinterInterface::class,
      'assets_list_printer' => \DrupalCodeGenerator\Helper\Printer\PrinterInterface::class,
    ]),
  );

  override(
    \Symfony\Component\Console\Command\Command::getHelper(0),
    map([
      'service_info' => \DrupalCodeGenerator\Helper\Drupal\ServiceInfo::class,
      'module_info' => \DrupalCodeGenerator\Helper\Drupal\ModuleInfo::class,
      'theme_info' => \DrupalCodeGenerator\Helper\Drupal\ThemeInfo::class,
      'hook_info' => \DrupalCodeGenerator\Helper\Drupal\HookInfo::class,
      'route_info' => \DrupalCodeGenerator\Helper\Drupal\RouteInfo::class,
      'permission_info' => \DrupalCodeGenerator\Helper\Drupal\PermissionInfo::class,
      'config_info' => \DrupalCodeGenerator\Helper\Drupal\ConfigInfo::class,
      'dry_dumper' => \DrupalCodeGenerator\Helper\Dumper\DumperInterface::class,
      'filesytem_dumper' => \DrupalCodeGenerator\Helper\Dumper\DumperInterface::class,
      'renderer' => \DrupalCodeGenerator\Helper\Renderer\RendererInterface::class,
      'question' => \DrupalCodeGenerator\Helper\QuestionHelper::class,
      'assets_table_printer' => \DrupalCodeGenerator\Helper\Printer\PrinterInterface::class,
      'assets_list_printer' => \DrupalCodeGenerator\Helper\Printer\PrinterInterface::class,
    ])
  );

  override(
    \Symfony\Component\DependencyInjection\ContainerInterface::get(0),
    map([
      'class_resolver' => \Drupal\Core\DependencyInjection\ClassResolverInterface::class,
      'entity_field.manager' => \Drupal\Core\Entity\EntityFieldManagerInterface::class,
      'entity_type.bundle.info' => \Drupal\Core\Entity\EntityTypeBundleInfoInterface::class,
      'entity_type.manager' => \Drupal\Core\Entity\EntityTypeManagerInterface::class,
      'event_dispatcher' => \Symfony\Contracts\EventDispatcher\EventDispatcherInterface::class,
      'extension.list.module' => \Drupal\Core\Extension\ModuleExtensionList::class,
      'kernel' => \Drupal\Core\DrupalKernelInterface::class,
    ])
  );

  override(\Drupal\Core\Routing\RouteProviderInterface::getAllRoutes(), map(['' => \ArrayIterator::class]));

}
