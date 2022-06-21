<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\Core\Extension\ThemeHandlerInterface;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Helper\Helper;

/**
 * A helper that provides information about installed Drupal themes.
 *
 * @todo Create a test for this.
 */
final class ThemeInfo extends Helper {

  public function __construct(private ThemeHandlerInterface $themeHandler) {}

  public function getName(): string {
    return 'theme_info';
  }

  /**
   * Returns a list of currently installed themes.
   */
  public function getThemes(): array {
    $themes = [];
    foreach ($this->themeHandler->listInfo() as $machine_name => $theme) {
      $themes[$machine_name] = $theme->info['name'];
    }
    return $themes;
  }

  /**
   * Returns destination for generated theme code.
   */
  public function getDestination(string $machine_name, bool $is_new): ?string {
    $themes_dir = \is_dir(\DRUPAL_ROOT . '/themes/custom') ?
      'themes/custom' : 'themes';

    if ($is_new) {
      $destination = $themes_dir;
    }
    else {
      $destination = \array_key_exists($machine_name, $this->getThemes())
        ? $this->themeHandler->getTheme($machine_name)->getPath()
        : $themes_dir . '/' . $machine_name;
    }

    return \DRUPAL_ROOT . '/' . $destination;
  }

  /**
   * Returns theme human name.
   */
  public function getThemeName(string $machine_name): ?string {
    return $this->getThemes()[$machine_name] ?? Utils::machine2human($machine_name);
  }

}
