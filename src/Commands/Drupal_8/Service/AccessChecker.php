<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Service;

use DrupalCodeGenerator\Commands\BaseGenerator;
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

    $this->services[$vars['machine_name'] . '.' . $vars['applies_to'] . '_access_checker'] = [
      'class' => 'Drupal\\' . $vars['machine_name'] . '\\Access\\' . $vars['class'],
      'tags' => [
        [
          'name' => 'access_check',
          'applies_to' => '_' . $vars['applies_to'],
        ],
      ],
    ];
  }

}
