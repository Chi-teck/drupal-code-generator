<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin\Field;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:field:type command.
 */
class Type extends BaseGenerator {

  protected $name = 'd8:plugin:field:type';
  protected $description = 'Generates field type plugin';
  protected $alias = 'field-type';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultPluginQuestions();

    $vars = $this->collectVars($input, $output, $questions);
    $vars['class'] = Utils::camelize($vars['plugin_label'] . 'Item');

    $path = 'src/Plugin/Field/FieldType/' . $vars['class'] . '.php';
    $this->setFile($path, 'd8/plugin/field/type.twig', $vars);
  }

}
