<?php

namespace DrupalCodeGenerator\Commands\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

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
      'docroot' => ['Document root', [$this, 'defaultDocumentRoot']],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['server_name']] = $this->render('other/nginx-virtual-host.twig', $vars);
  }

  /**
   * Returns default answer for docroot question.
   */
  protected function defaultDocumentRoot($vars) {
    return '/var/www/' . $vars['server_name'] . '/docroot';
  }

}
