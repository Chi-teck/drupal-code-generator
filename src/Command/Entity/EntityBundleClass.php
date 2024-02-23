<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Entity;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Exception\RuntimeException;
use DrupalCodeGenerator\GeneratorType;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Generator(
  name: 'entity:bundle-class',
  description: 'Generate a bundle class for a content entity.',
  aliases: ['bundle-class'],
  templatePath: Application::TEMPLATE_PATH . '/Entity/_entity-bundle-class',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class EntityBundleClass extends BaseGenerator implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly EntityTypeBundleInfoInterface $bundleInfo,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('entity_type.manager'),
      $container->get('entity_type.bundle.info'),
    );
  }

  /**
   * {@inheritdoc}
   *
   * @psalm-suppress PossiblyInvalidArgument
   * @psalm-suppress PossiblyUndefinedStringArrayOffset
   * @psalm-suppress PossiblyInvalidArrayOffset
   */
  protected function generate(array &$vars, AssetCollection $assets): void {

    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    /** @psalm-var array<string, \Drupal\Core\Entity\ContentEntityTypeInterface> $definitions */
    $definitions = \array_filter(
      $this->entityTypeManager->getDefinitions(),
      static fn (EntityTypeInterface $definition): bool => $definition->getGroup() === 'content',
    );

    $entity_types = \array_map(
      static fn (ContentEntityTypeInterface $definition): string => (string) $definition->get('label'),
      $definitions,
    );
    $vars['entity_type_id'] = $ir->choice('Entity type', $entity_types);

    // @todo Should this use 'original_class' instead?
    $vars['entity_class_fqn'] = $definitions[$vars['entity_type_id']]->get('class');
    $vars['entity_class'] = \array_slice(\explode('\\', $vars['entity_class_fqn']), -1)[0];
    $vars['namespace'] = 'Drupal\\\{machine_name}\Entity\\\{entity_class}';

    $bundles = \array_map(
      static fn (array $bundle): string => (string) $bundle['label'],
      $this->bundleInfo->getBundleInfo($vars['entity_type_id']),
    );
    if (\count($bundles) === 0) {
      throw new RuntimeException(
        \sprintf('The "%s" entity type has no bundles.', $entity_types[$vars['entity_type_id']]),
      );
    }

    // Skip the question if only 1 bundle exists.
    $bundle_ids = \count($bundles) === 1 ?
      \array_keys($bundles) : $ir->choice('Bundles, comma separated', $bundles, NULL, TRUE);

    $vars['classes'] = [];
    $vars['classes_fqn'] = [];
    /** @psalm-var list<string> $bundle_ids */
    foreach ($bundle_ids as $bundle_id) {
      $vars['bundle_id'] = $bundle_id;
      $vars['class'] = $ir->ask(
        \sprintf('Class for "%s" bundle', $bundles[$bundle_id]),
        '{bundle_id|camelize}',
      );
      $assets->addFile('src/Entity/{entity_class}/{class}.php', 'bundle-class.twig')->vars($vars);
      // Track all bundle classes to generate hook_entity_bundle_info_alter().
      $vars['classes'][$bundle_id] = $vars['class'];
      $vars['classes_fqn'][$bundle_id] = '\\' . $vars['namespace'] . '\\' . $vars['class'];
    }

    $vars['base_class'] = NULL;
    if ($ir->confirm('Use a base class?', FALSE)) {
      $vars['base_class'] = $ir->ask('Base class', '{entity_type_id|camelize}Base');
      $assets->addFile('src/Entity/{entity_class}/{base_class}.php', 'bundle-base-class.twig');
    }

    // @todo Handle duplicated hooks.
    $assets->addFile('{machine_name}.module', 'module.twig')
      ->appendIfExists(9);
  }

}
