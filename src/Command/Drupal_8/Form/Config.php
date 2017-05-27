<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Form;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:form:config command.
 */
class Config extends BaseGenerator {

  protected $name = 'd8:form:config';
  protected $description = 'Generates a configuration form';
  protected $alias = 'config-form';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'class' => ['Class', 'SettingsForm'],
      'form_id' => [
        'Form ID',
        function ($vars) {
          return $vars['machine_name'] . '_settings';
        },
      ],
    ];
    $vars = $this->collectVars($input, $output, $questions);
    $path = 'src/Form/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/form/config.twig', $vars);
  }

}
