<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Plugin;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\RequiredMachineName;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Generator(
  name: 'plugin:action',
  description: 'Generates action plugin',
  aliases: ['action'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_action',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Action extends BaseGenerator implements ContainerInjectionInterface {

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
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_label'] = $ir->askPluginLabel('Action label');
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass();

    $vars['category'] = $ir->ask('Action category', 'Custom');

    // @todo Create a helper for this.
    $definitions = \array_filter(
      $this->entityTypeManager->getDefinitions(),
      static fn (EntityTypeInterface $definition): bool => $definition instanceof ContentEntityTypeInterface,
    );
    $entity_type_question = new Question('Entity type to apply the action', 'node');
    $entity_type_question->setValidator(new RequiredMachineName());
    $entity_type_question->setAutocompleterValues(\array_keys($definitions));
    $vars['entity_type'] = $this->io()->askQuestion($entity_type_question);

    $vars['configurable'] = $ir->confirm('Make the action configurable?', FALSE);
    $vars['services'] = $ir->askServices(FALSE);

    $assets->addFile('src/Plugin/Action/{class}.php', 'action.twig');

    if ($vars['configurable']) {
      $assets->addSchemaFile()->template('schema.twig');
    }
  }

}
