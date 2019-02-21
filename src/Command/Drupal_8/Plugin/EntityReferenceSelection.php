<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:entity-reference-selection command.
 */
class EntityReferenceSelection extends BaseGenerator {

  protected $name = 'd8:plugin:entity-reference-selection';
  protected $description = 'Generates entity reference selection plugin';
  protected $alias = 'entity-reference-selection';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $base_classes = [
      'comment' => 'Drupal\comment\Plugin\EntityReferenceSelection\CommentSelection',
      'file' => 'Drupal\file\Plugin\EntityReferenceSelection\FileSelection',
      'node' => 'Drupal\node\Plugin\EntityReferenceSelection\NodeSelection',
      'taxonomy_term' => 'Drupal\taxonomy\Plugin\EntityReferenceSelection\TermSelection',
      'user' => 'Drupal\user\Plugin\EntityReferenceSelection\UserSelection',
    ];

    $questions = Utils::moduleQuestions();

    $questions['entity_type'] = new Question('Entity type that can be referenced by this plugin', 'node');
    $questions['entity_type']->setValidator([Utils::class, 'validateMachineName']);
    $questions['entity_type']->setAutocompleterValues(array_keys($base_classes));

    $questions['plugin_label'] = new Question('Plugin label', 'Advanced {entity_type} selection');
    $questions['plugin_label']->setValidator([Utils::class, 'validateRequired']);

    $questions['plugin_id'] = new Question('Plugin ID', [Utils::class, 'defaultPluginId']);
    $questions['plugin_id']->setValidator([Utils::class, 'validateMachineName']);

    $default_class = function ($vars) {
      return Utils::camelize($vars['entity_type']) . 'Selection';
    };
    $questions['class'] = new Question('Plugin class', $default_class);

    $questions['configurable'] = new ConfirmationQuestion('Provide additional plugin configuration?', FALSE);
    $vars = &$this->collectVars($input, $output, $questions);

    if (isset($base_classes[$vars['entity_type']])) {
      $vars['base_class_full'] = $base_classes[$vars['entity_type']];
    }
    else {
      $vars['base_class_full'] = 'Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection';
    }

    $vars['base_class'] = explode('EntityReferenceSelection\\', $vars['base_class_full'])[1];

    $this->addFile()
      ->path('src/Plugin/EntityReferenceSelection/{class}.php')
      ->template('d8/plugin/entity-reference-selection.twig');

    $this->addFile()
      ->path('config/schema/{machine_name}.schema.yml')
      ->template('d8/plugin/entity-reference-selection-schema.twig')
      ->action('append');
  }

}
