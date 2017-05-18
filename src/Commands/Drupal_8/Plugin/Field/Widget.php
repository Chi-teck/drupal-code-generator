<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:field:widget command.
 */
class Widget extends BaseGenerator {

  protected $name = 'd8:plugin:field:widget';
  protected $description = 'Generates field widget plugin';
  protected $alias = 'widget';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'plugin_label' => ['Widget name', 'Example'],
      'plugin_id' => ['Widget machine name'],
    ];

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label'] . 'Widget');

    $path = 'src/Plugin/Field/FieldWidget/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/plugin/field/widget.twig', $vars);
  }

}
