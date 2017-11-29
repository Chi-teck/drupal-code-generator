<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements other:nginx-virtual-host command.
 */
class NginxVirtualHost extends BaseGenerator {

  protected $name = 'other:nginx-virtual-host';
  protected $description = 'Generates an Nginx site configuration file';
  protected $alias = 'nginx-virtual-host';
  protected $destination = '/etc/nginx/sites-available';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $socket = PHP_MAJOR_VERSION == 5
      ? '/run/php5-fpm.sock'
      : sprintf('/run/php/php%s.%s-fpm.sock', PHP_MAJOR_VERSION, PHP_MINOR_VERSION);

    $questions = [
      'server_name' => new Question('Server name', 'example.com'),
      'docroot' => new Question('Document root', '/var/www/{server_name}/docroot'),
      'file_public_path' => new Question('Public file system path', 'sites/default/files'),
      'file_private_path' => new Question('Private file system path'),
      'fastcgi_pass' => new Question('Address of a FastCGI server', 'unix:' . $socket),
    ];

    $vars = &$this->collectVars($input, $output, $questions);

    $vars['file_public_path'] = trim($vars['file_public_path'], '/');
    $vars['file_private_path'] = trim($vars['file_private_path'], '/');

    $this->addFile()
      ->path('{server_name}')
      ->template('other/nginx-virtual-host.twig');
  }

}
