<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Service;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Commands\Utils;
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
          return Utils::human2class($vars['parameter_type'] . 'ParamConverter');
        },
      ],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $vars['controller_class'] = Utils::human2class($vars['machine_name']) . 'Controller';

    $path = 'src/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/service/param-converter.twig', $vars);

    $this->services[$vars['machine_name'] . '.' . $vars['parameter_type'] . '_param_converter'] = [
      'class' => 'Drupal\\' . $vars['machine_name'] . '\\' . $vars['class'],
      'arguments' => ['@database'],
      'tags' => [
        [
          'name' => 'paramconverter',
        ],
      ],
    ];
  }

}
