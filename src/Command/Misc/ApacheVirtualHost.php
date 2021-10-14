<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Generator;

/**
 * Implements misc:apache-virtual-host command.
 */
final class ApacheVirtualHost extends Generator {

  protected string $name = 'misc:apache-virtual-host';
  protected string $description = 'Generates an Apache site configuration file';
  protected string $alias = 'apache-virtual-host';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/apache-virtual-host';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $validator = static function (?string $value): string {
      $value = self::validateRequired($value);
      if (!\filter_var($value, \FILTER_VALIDATE_DOMAIN, \FILTER_FLAG_HOSTNAME)) {
        throw new \UnexpectedValueException('The value is not correct domain name.');
      }
      return $value;
    };
    $vars['hostname'] = $this->ask('Host name', 'example.local', $validator);
    $vars['docroot'] = $this->ask('Document root', '/var/www/{hostname}/public');
    $this->addFile('{hostname}.conf', 'host');
    $this->addFile('{hostname}-ssl.conf', 'host-ssl');
  }

}
