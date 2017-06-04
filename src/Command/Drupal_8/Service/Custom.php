<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:service:custom command.
 */
class Custom extends BaseGenerator {

  protected $name = 'd8:service:custom';
  protected $description = 'Generates a custom Drupal service';
  protected $alias = 'service';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'service_name' => [
        'Service name',
        function ($vars) {
          return $vars['machine_name'] . '.example';
        },
      ],
      'class' => ['Class', 'Example'],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $path = 'src/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/service/custom.twig', $vars);

    $this->setServicesFile($vars['machine_name'] . '.services.yml', 'd8/service/custom.services.twig', $vars);
  }

}
