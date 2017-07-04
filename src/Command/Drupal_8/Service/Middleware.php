<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:service:middleware command.
 */
class Middleware extends BaseGenerator {

  protected $name = 'd8:service:middleware';
  protected $description = 'Generates a middleware';
  protected $alias = 'middleware';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['name'] . 'Middleware');

    $path = 'src/' . $vars['class'] . '.php';
    $this->setFile($path, 'd8/service/middleware.twig', $vars);

    $this->setServicesFile($vars['machine_name'] . '.services.yml', 'd8/service/middleware.services.twig', $vars);
  }

}
