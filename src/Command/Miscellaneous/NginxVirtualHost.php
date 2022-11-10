<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Miscellaneous;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

/**
 * Nginx config generator.
 *
 * @todo Clean-up.
 */
#[Generator(
  name: 'misc:nginx-virtual-host',
  description: 'Generates an Nginx site configuration file',
  aliases: ['nginx-virtual-host'],
  templatePath: Application::TEMPLATE_PATH . '/Miscellaneous/_nginx-virtual-host',
  type: GeneratorType::OTHER,
)]
final class NginxVirtualHost extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $socket = \PHP_MAJOR_VERSION == 5
      ? '/run/php5-fpm.sock'
      : \sprintf('/run/php/php%s.%s-fpm.sock', \PHP_MAJOR_VERSION, \PHP_MINOR_VERSION);

    $vars['server_name'] = $this->io()->ask('Server name', 'example.com');
    $vars['docroot'] = $this->io()->ask('Document root', "/var/www/{$vars['server_name']}/docroot");
    $vars['file_public_path'] = $this->io()->ask('Public file system path', 'sites/default/files');
    $vars['file_private_path'] = $this->io()->ask('Private file system path');
    $vars['fastcgi_pass'] = $this->io()->ask('Address of a FastCGI server', 'unix:' . $socket);

    if ($vars['file_public_path']) {
      $vars['file_public_path'] = \trim($vars['file_public_path'], '/');
    }
    if ($vars['file_private_path']) {
      $vars['file_private_path'] = \trim($vars['file_private_path'], '/');
    }

    $assets->addFile('{server_name}', 'host.twig');
  }

}
