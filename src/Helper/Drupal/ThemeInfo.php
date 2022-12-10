<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Helper\Drupal;

use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Symfony\Component\Console\Helper\Helper;

/**
 * A helper that provides information about installed Drupal themes.
 *
 * @todo Create a test for this.
 */
final class ThemeInfo extends Helper implements ExtensionInfoInterface {

  /**
   * Constructs the object.
   */
  public function __construct(private readonly ThemeHandlerInterface $themeHandler) {}

  /**
   * {@inheritdoc}
   */
  public function getName(): string {
    return 'theme_info';
  }

  /**
   * {@inheritdoc}
   */
  public function getExtensions(): array {
    $themes = [];
    foreach ($this->themeHandler->listInfo() as $machine_name => $theme) {
      if (!isset($theme->info['name'])) {
        throw new \RuntimeException('Missing theme name');
      }
      $themes[$machine_name] = $theme->info['name'];
    }
    return $themes;
  }

  /**
   * {@inheritdoc}
   */
  public function getDestination(string $machine_name, bool $is_new): string {
    $themes_dir = \is_dir(\DRUPAL_ROOT . '/themes/custom') ?
      'themes/custom' : 'themes';

    if ($is_new) {
      $destination = $themes_dir;
    }
    else {
      $destination = \array_key_exists($machine_name, $this->getExtensions())
        ? $this->themeHandler->getTheme($machine_name)->getPath()
        : $themes_dir . '/' . $machine_name;
    }

    return \DRUPAL_ROOT . '/' . $destination;
  }

  /**
   * {@inheritdoc}
   */
  public function getExtensionName(string $machine_name): ?string {
    return $this->getExtensions()[$machine_name] ?? NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getExtensionMachineName(string $name): ?string {
    return \array_search($name, $this->getExtensions()) ?: NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getExtensionFromPath(string $path): ?Extension {
    if (!\str_starts_with($path, '/')) {
      throw new \InvalidArgumentException('The path must be absolute.');
    }
    // @todo Implements this.
    return NULL;
  }

}
