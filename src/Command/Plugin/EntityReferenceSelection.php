<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin;

use Drupal\comment\Plugin\EntityReferenceSelection\CommentSelection;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection;
use Drupal\file\Plugin\EntityReferenceSelection\FileSelection;
use Drupal\node\Plugin\EntityReferenceSelection\NodeSelection;
use Drupal\taxonomy\Plugin\EntityReferenceSelection\TermSelection;
use Drupal\user\Plugin\EntityReferenceSelection\UserSelection;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\RequiredMachineName;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Generator(
  name: 'plugin:entity-reference-selection',
  description: 'Generates entity reference selection plugin',
  aliases: ['entity-reference-selection'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_entity-reference-selection',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class EntityReferenceSelection extends BaseGenerator implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self($container->get('entity_type.manager'));
  }

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $entity_type_question = new Question('Entity type that can be referenced by this plugin', 'node');
    $entity_type_question->setValidator(new RequiredMachineName());
    $entity_types = \array_keys($this->entityTypeManager->getDefinitions());
    $entity_type_question->setAutocompleterValues($entity_types);
    $vars['entity_type'] = $this->io()->askQuestion($entity_type_question);

    $vars['plugin_label'] = $ir->askPluginLabel('Plugin label', 'Advanced {entity_type} selection');
    $vars['plugin_id'] = $ir->askPluginId(default: '{machine_name}_{entity_type}_selection');

    $vars['class'] = $ir->askPluginClass(default: '{entity_type|camelize}Selection');

    $vars['configurable'] = $ir->confirm('Provide additional plugin configuration?', FALSE);

    $vars['base_class_full'] = match($vars['entity_type']) {
      'comment' => CommentSelection::class,
      'file' => FileSelection::class,
      'node' => NodeSelection::class,
      'taxonomy_term' => TermSelection::class,
      'user' => UserSelection::class,
      default => DefaultSelection::class,
    };

    $vars['base_class'] = \explode('EntityReferenceSelection\\', $vars['base_class_full'])[1];

    $assets->addFile('src/Plugin/EntityReferenceSelection/{class}.php')
      ->template('entity-reference-selection.twig');
    $assets->addSchemaFile()->template('schema.twig');
  }

}
