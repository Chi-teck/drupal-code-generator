<?php

namespace DrupalCodeGenerator\Command\Other;

use DrupalCodeGenerator\Command\BaseGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements other:apache-virtual-host command.
 */
class ApacheVirtualHost extends BaseGenerator {

  protected $name = 'other:apache-virtual-host';
  protected $description = 'Generates an Apache site configuration file';
  protected $alias = 'apache-virtual-host';
  protected $destination = '/etc/apache2/sites-available';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $default_docroot = function ($vars) {
      return '/var/www/' . $vars['hostname'] . '/public';
    };

    $questions = [
      'hostname' => new Question('Host name', 'example.com'),
      'docroot' => new Question('Document root', $default_docroot),
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $this->setFile($vars['hostname'] . '.conf', 'other/apache-virtual-host.twig', $vars);
  }

}
