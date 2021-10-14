<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use DrupalCodeGenerator\Application;
use Symfony\Component\Console\Question\Question;

/**
 * Implements plugin:entity-reference-selection command.
 */
final class EntityReferenceSelection extends PluginGenerator {

  protected string $name = 'plugin:entity-reference-selection';
  protected string $description = 'Generates entity reference selection plugin';
  protected string $alias = 'entity-reference-selection';
  protected string $templatePath = Application::TEMPLATE_PATH . '/plugin/entity-reference-selection';

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
    $vars['name'] = $this->askName();
    $vars['machine_name'] = $this->askMachineName($vars);

    $entity_type_question = new Question('Entity type that can be referenced by this plugin', 'node');
    $entity_type_question->setValidator([self::class, 'validateRequiredMachineName']);
    $entity_type_question->setAutocompleterValues(\array_keys(self::baseClasses()));
    $vars['entity_type'] = $this->io->askQuestion($entity_type_question);

    $vars['plugin_label'] = $this->askPluginLabelQuestion();
    $vars['plugin_id'] = $this->askPluginIdQuestion();
    $vars['class'] = $this->askPluginClassQuestion($vars);
  }

  /**
   * Asks plugin label question.
   */
  protected function askPluginLabelQuestion(): ?string {
    return $this->ask('Plugin label', 'Advanced {entity_type} selection', '::validateRequired');
  }

  /**
   * Asks plugin class question.
   */
  protected function askPluginClassQuestion(array $vars): string {
    return $this->ask('Plugin class', '{entity_type|camelize}Selection');
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
