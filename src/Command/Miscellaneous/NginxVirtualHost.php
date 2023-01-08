<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Miscellaneous;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\Required;

/**
 * Nginx config generator.
 */
#[Generator(
  name: 'misc:nginx-virtual-host',
  description: 'Generates an Nginx site configuration file',
  aliases: ['nginx-virtual-host'],
  templatePath: Application::TEMPLATE_PATH . '/Miscellaneous/_nginx-virtual-host',
  type: GeneratorType::OTHER,
)]
final class NginxVirtualHost extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $socket = \sprintf('/run/php/php%s.%s-fpm.sock', \PHP_MAJOR_VERSION, \PHP_MINOR_VERSION);

    $vars['hostname'] = $this->io()->ask('Host name', 'example.local', self::getDomainValidator());
    $vars['docroot'] = $this->io()->ask('Document root', \DRUPAL_ROOT);
    $vars['file_public_path'] = $this->io()->ask('Public file system path', 'sites/default/files');
    $vars['file_private_path'] = $this->io()->ask('Private file system path');
    $vars['fastcgi_pass'] = $this->io()->ask('Address of a FastCGI server', 'unix:' . $socket);

    if ($vars['file_public_path']) {
      $vars['file_public_path'] = \trim($vars['file_public_path'], '/');
    }
    if ($vars['file_private_path']) {
      $vars['file_private_path'] = \trim($vars['file_private_path'], '/');
    }

    $assets->addFile('{hostname}', 'host.twig');
  }

  /**
   * Builds domain validator.
   */
  private static function getDomainValidator(): callable {
    return new Chained(
      new Required(),
      static function (string $value): string {
        if (!\filter_var($value, \FILTER_VALIDATE_DOMAIN, \FILTER_FLAG_HOSTNAME)) {
          throw new \UnexpectedValueException('The value is not correct domain name.');
        }
        return $value;
      },
    );
  }

}
