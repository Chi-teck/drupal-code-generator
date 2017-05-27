<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements other:nginx-virtual-host command.
 */
class NginxVirtualHost extends BaseGenerator {

  protected $name = 'other:nginx-virtual-host';
  protected $description = 'Generates an Nginx site configuration file';
  protected $alias = 'nginx-virtual-host';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'server_name' => ['Server name', 'example.com'],
      'docroot' => [
        'Document root',
        function ($vars) {
          return '/var/www/' . $vars['server_name'] . '/docroot';
        },
      ],
      'file_public_path' => ['Public file system path', 'sites/default/files'],
      'file_private_path' => ['Private file system path', NULL, FALSE],
      'fastcgi_pass' => ['Address of a FastCGI server', 'unix:/run/php/php7.0-fpm.sock'],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $vars['file_public_path'] = trim($vars['file_public_path'], '/');
    $vars['file_private_path  '] = trim($vars['file_private_path'], '/');

    $this->files[$vars['server_name']] = $this->render('other/nginx-virtual-host.twig', $vars);
  }

}
