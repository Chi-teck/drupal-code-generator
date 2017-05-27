<?php

namespace DrupalCodeGenerator\Command\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;

/**
 * Implements other:apache-virtual-host command.
 */
class ApacheVirtualHost extends BaseGenerator {

  protected $name = 'other:apache-virtual-host';
  protected $description = 'Generates an Apache site configuration file';
  protected $alias = 'apache-virtual-host';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = [
      'hostname' => ['Host name', 'example.com'],
      'docroot' => [
        'Document root',
        function ($vars) {
          return '/var/www/' . $vars['hostname'] . '/public';
        },
      ],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $this->files[$vars['hostname'] . '.conf'] = $this->render('other/apache-virtual-host.twig', $vars);
  }

}
