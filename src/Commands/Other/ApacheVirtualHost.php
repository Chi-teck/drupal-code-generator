<?php

namespace DrupalCodeGenerator\Commands\Other;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 *
 */
class ApacheVirtualHost extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected static  $name = 'generate:other:apache-virtual-host';

  /**
   * {@inheritdoc}
   */
  protected static $description = 'Generate an Apache site configuration file.';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'hostname' => ['Host name', 'example.com'],
      'docroot' => ['Document root', [$this, 'defaultDocumentRoot']],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $this->files[$vars['hostname'] . '.conf'] = $this->render('other/apache-virtual-host.twig', $vars);

  }

  protected function defaultDocumentRoot($vars) {
    return '/var/www/' . $vars['hostname'] . '/public';
  }


}
