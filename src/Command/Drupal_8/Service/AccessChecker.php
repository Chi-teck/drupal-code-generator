<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:service:access-checker command.
 */
class AccessChecker extends BaseGenerator {

  protected $name = 'd8:service:access-checker';
  protected $description = 'Generates an access checker service';
  protected $alias = 'access-checker';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'applies_to' => ['Applies to', 'foo'],
      'class' => [
        'Class',
        function ($vars) {
          return Utils::camelize($vars['applies_to'] . 'AccessChecker');
        },
      ],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $path = 'src/Access/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/service/access-checker.twig', $vars);

    $this->setServicesFile($vars['machine_name'] . '.services.yml', 'd8/service/access-checker.services.twig', $vars);
  }

}
