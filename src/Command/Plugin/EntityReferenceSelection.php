<?php

namespace DrupalCodeGenerator\Command\Plugin;

use Symfony\Component\Console\Question\Question;

/**
 * Implements plugin:entity-reference-selection command.
 */
final class EntityReferenceSelection extends PluginGenerator {

  protected $name = 'plugin:entity-reference-selection';
  protected $description = 'Generates entity reference selection plugin';
  protected $alias = 'entity-reference-selection';
  protected $pluginLabelDefault = 'Advanced {entity_type} selection';
  protected $pluginClassDefault = '{entity_type|camelize}Selection';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['configurable'] = $this->confirm('Provide additional plugin configuration?', FALSE);

    $vars['base_class_full'] = self::baseClasses()[$vars['entity_type']] ??
      'Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection';

    $vars['base_class'] = \explode('EntityReferenceSelection\\', $vars['base_class_full'])[1];

    $this->addFile('src/Plugin/EntityReferenceSelection/{class}.php')
      ->template('entity-reference-selection');
    $this->addSchemaFile()->template('schema');
  }

  /**
   * {@inheritdoc}
   */
  protected function collectDefault(array &$vars): void {
    $vars['name'] = $this->askNameQuestion();
    $vars['machine_name'] = $this->askMachineNameQuestion($vars);

    $entity_type_question = new Question('Entity type that can be referenced by this plugin', 'node');
    $entity_type_question->setValidator([self::class, 'validateRequiredMachineName']);
    $entity_type_question->setAutocompleterValues(\array_keys(self::baseClasses()));
    $vars['entity_type'] = $this->io->askQuestion($entity_type_question);

    $vars['plugin_label'] = $this->askPluginLabelQuestion();
    $vars['plugin_id'] = $this->askPluginIdQuestion();
    $vars['class'] = $this->askPluginClassQuestion($vars);
  }

  /**
   * Base classes for the plugin.
   */
  private static function baseClasses(): array {
    return [
      'comment' => 'Drupal\comment\Plugin\EntityReferenceSelection\CommentSelection',
      'file' => 'Drupal\file\Plugin\EntityReferenceSelection\FileSelection',
      'node' => 'Drupal\node\Plugin\EntityReferenceSelection\NodeSelection',
      'taxonomy_term' => 'Drupal\taxonomy\Plugin\EntityReferenceSelection\TermSelection',
      'user' => 'Drupal\user\Plugin\EntityReferenceSelection\UserSelection',
    ];
  }

}
