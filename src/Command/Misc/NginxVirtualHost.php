<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\Generator;

/**
 * Implements misc:nginx-virtual-host command.
 */
final class NginxVirtualHost extends Generator {

  protected string $name = 'misc:nginx-virtual-host';
  protected string $description = 'Generates an Nginx site configuration file';
  protected string $alias = 'nginx-virtual-host';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/nginx-virtual-host';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $socket = \PHP_MAJOR_VERSION == 5
      ? '/run/php5-fpm.sock'
      : \sprintf('/run/php/php%s.%s-fpm.sock', \PHP_MAJOR_VERSION, \PHP_MINOR_VERSION);

    $vars['server_name'] = $this->ask('Server name', 'example.com');
    $vars['docroot'] = $this->ask('Document root', '/var/www/{server_name}/docroot');
    $vars['file_public_path'] = $this->ask('Public file system path', 'sites/default/files');
    $vars['file_private_path'] = $this->ask('Private file system path');
    $vars['fastcgi_pass'] = $this->ask('Address of a FastCGI server', 'unix:' . $socket);

    $vars['file_public_path'] = \trim($vars['file_public_path'], '/');
    $vars['file_private_path'] = \trim($vars['file_private_path'], '/');

    $this->addFile('{server_name}', 'host.twig');
  }

}
