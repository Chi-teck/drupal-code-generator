<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\RequiredMachineName;
use Symfony\Component\Console\Question\Question;

#[Generator(
  name: 'plugin:entity-reference-selection',
  description: 'Generates entity reference selection plugin',
  aliases: ['entity-reference-selection'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_entity-reference-selection',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class EntityReferenceSelection extends BaseGenerator {

  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $entity_type_question = new Question('Entity type that can be referenced by this plugin', 'node');
    $entity_type_question->setValidator(new RequiredMachineName());
    // Reference all available entity types.
    $entity_type_question->setAutocompleterValues(\array_keys(self::baseClasses()));
    $vars['entity_type'] = $this->io()->askQuestion($entity_type_question);

    $vars['plugin_label'] = $ir->askPluginLabel('Plugin label', 'Advanced {entity_type} selection');
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass(default: '{entity_type|camelize}Selection');

    $vars['configurable'] = $ir->confirm('Provide additional plugin configuration?', FALSE);

    $vars['base_class_full'] = self::baseClasses()[$vars['entity_type']] ??
      'Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection';

    $vars['base_class'] = \explode('EntityReferenceSelection\\', $vars['base_class_full'])[1];

    $assets->addFile('src/Plugin/EntityReferenceSelection/{class}.php')
      ->template('entity-reference-selection.twig');
    $assets->addSchemaFile()->template('schema.twig');
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
