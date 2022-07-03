<?php /** @noinspection ALL */

namespace PHPSTORM_META {

  override(
    \Symfony\Component\Console\Helper\HelperSet::get(),
    map([
      'service_info' => \DrupalCodeGenerator\Helper\Drupal\ServiceInfo::class,
      'module_info' => \DrupalCodeGenerator\Helper\Drupal\ModuleInfo::class,
      'theme_info' => \DrupalCodeGenerator\Helper\Drupal\ThemeInfo::class,
      'hook_info' => \DrupalCodeGenerator\Helper\Drupal\HookInfo::class,
      'dry_dumper' => \DrupalCodeGenerator\Helper\Dumper\DryDumper::class,
      'filesytem_dumper' => \DrupalCodeGenerator\Helper\Dumper\FileSystemDumper::class,
      'renderer' => \DrupalCodeGenerator\Helper\RendererInterface::class,
      'question_helper' => \DrupalCodeGenerator\Helper\QuestionHelper::class,
      'result_printer' => \DrupalCodeGenerator\Helper\ResultPrinter::class,
    ]),
  );

  override(
    \Symfony\Component\Console\Command\Command::getHelper(),
    map([
      'service_info' => \DrupalCodeGenerator\Helper\Drupal\ServiceInfo::class,
      'module_info' => \DrupalCodeGenerator\Helper\Drupal\ModuleInfo::class,
      'theme_info' => \DrupalCodeGenerator\Helper\Drupal\ThemeInfo::class,
      'hook_info' => \DrupalCodeGenerator\Helper\Drupal\HookInfo::class,
      'dry_dumper' => \DrupalCodeGenerator\Helper\Dumper\DryDumper::class,
      'filesytem_dumper' => \DrupalCodeGenerator\Helper\Dumper\FileSystemDumper::class,
      'renderer' => \DrupalCodeGenerator\Helper\RendererInterface::class,
      'question_helper' => \DrupalCodeGenerator\Helper\QuestionHelper::class,
      'result_printer' => \DrupalCodeGenerator\Helper\ResultPrinter::class,
    ])
  );

}
