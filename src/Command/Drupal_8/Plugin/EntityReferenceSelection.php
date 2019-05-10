<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Plugin;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:plugin:entity-reference-selection command.
 */
class EntityReferenceSelection extends ModuleGenerator {

  protected $name = 'd8:plugin:entity-reference-selection';
  protected $description = 'Generates entity reference selection plugin';
  protected $alias = 'entity-reference-selection';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $base_classes = [
      'comment' => 'Drupal\comment\Plugin\EntityReferenceSelection\CommentSelection',
      'file' => 'Drupal\file\Plugin\EntityReferenceSelection\FileSelection',
      'node' => 'Drupal\node\Plugin\EntityReferenceSelection\NodeSelection',
      'taxonomy_term' => 'Drupal\taxonomy\Plugin\EntityReferenceSelection\TermSelection',
      'user' => 'Drupal\user\Plugin\EntityReferenceSelection\UserSelection',
    ];

    $entity_type_question = new Question('Entity type that can be referenced by this plugin', 'node');
    $entity_type_question->setValidator([Utils::class, 'validateMachineName']);
    $entity_type_question->setAutocompleterValues(array_keys($base_classes));
    $vars['entity_type'] = $this->askQuestion($entity_type_question);

    $vars['plugin_label'] = $this->ask('Plugin label', 'Advanced {entity_type} selection', [Utils::class, 'validateRequired']);
    $default_plugin_id = $vars['machine_name'] . '_' . Utils::human2machine($vars['plugin_label']);
    $vars['plugin_id'] = $this->ask('Plugin ID', $default_plugin_id, [Utils::class, 'validateRequired']);

    $vars['class'] = $this->ask('Plugin class', '{entity_type|camelize}Selection');

    $vars['configurable'] = $this->confirm('Provide additional plugin configuration?', FALSE);

    $vars['base_class_full'] = $base_classes[$vars['entity_type']] ??
      'Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection';

    $vars['base_class'] = explode('EntityReferenceSelection\\', $vars['base_class_full'])[1];

    $this->addFile('src/Plugin/EntityReferenceSelection/{class}.php')
      ->template('d8/plugin/entity-reference-selection');

    $this->addFile('config/schema/{machine_name}.schema.yml')
      ->template('d8/plugin/entity-reference-selection-schema')
      ->action('append');
  }

}
