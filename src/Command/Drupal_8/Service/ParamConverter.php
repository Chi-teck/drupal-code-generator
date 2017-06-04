<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:service:param-converter command.
 */
class ParamConverter extends BaseGenerator {

  protected $name = 'd8:service:param-converter';
  protected $description = 'Generates a param converter service';
  protected $alias = 'param-converter';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'parameter_type' => ['Param type', 'example_record'],
      'class' => [
        'Class',
        function ($vars) {
          return Utils::camelize($vars['parameter_type'] . 'ParamConverter');
        },
      ],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $vars['controller_class'] = Utils::camelize($vars['machine_name']) . 'Controller';

    $path = 'src/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/service/param-converter.twig', $vars);

    $this->setServicesFile($vars['machine_name'] . '.services.yml', 'd8/service/param-converter.services.twig', $vars);
  }

}
