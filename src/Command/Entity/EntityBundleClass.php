<?php declare(strict_types = 1);

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
use DrupalCodeGenerator\Exception\UnexpectedValueException;
use DrupalCodeGenerator\GeneratorType;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Generator(
  name: 'entity:bundle-class',
  description: 'Generate a bundle class for a content entity.',
  aliases: ['bundle-class'],
  templatePath: Application::TEMPLATE_PATH . '/entity-bundle-class',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class EntityBundleClass extends BaseGenerator implements ContainerInjectionInterface {

  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly EntityTypeBundleInfoInterface $bundleInfo,
  ) {
    parent::__construct();
  }

  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('entity_type.manager'),
      $container->get('entity_type.bundle.info'),
    );
  }

  protected function generate(array &$vars, AssetCollection $assets): void {

    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['namespace'] = 'Drupal\\\{machine_name}\Entity\Bundle';

    $definitions = \array_filter(
      $this->entityTypeManager->getDefinitions(),
      static fn (EntityTypeInterface $definition): bool => $definition->getGroup() === 'content',
    );

    $entity_type_choices = \array_map(
      static fn (ContentEntityTypeInterface $definition): string => (string) $definition->get('label'),
      $definitions,
    );
    $vars['entity_type_id'] = $ir->choice('Entity type', $entity_type_choices);

    // @todo Should this use 'original_class' instead?
    $vars['entity_class_fqn'] = $definitions[$vars['entity_type_id']]->get('class');
    $vars['entity_class'] = \array_slice(\explode('\\', $vars['entity_class_fqn']), -1)[0];

    $bundles = \array_map(
      static fn (array $bundle): string => (string) $bundle['label'],
      $this->bundleInfo->getBundleInfo($vars['entity_type_id']),
    );

    // Skip the question when only 1 bundle exists.
    if (\count($bundles) === 1) {
      $vars['bundle_ids'] = \array_keys($bundles);
    }
    else {
      // Prepend an 'All' choice for user's convenience.
      $bundle_choices = ['' => 'All'] + $bundles;
      $vars['bundle_ids'] = $ir->choice('Bundles, comma separated', $bundle_choices, NULL, TRUE);
      if (\in_array('', $vars['bundle_ids'])) {
        // @todo create a test for this.
        if (\count($vars['bundle_ids']) >= 2) {
          throw new UnexpectedValueException("'All' may not be combined with other choices.");
        }
        // Replace 'all' with all bundle IDs.
        $vars['bundle_ids'] = \array_keys($bundles);
      }
    }

    $vars['classes'] = [];
    $vars['classes_fqn'] = [];
    foreach ($vars['bundle_ids'] as $bundle_id) {
      $vars['bundle_id'] = $bundle_id;
      $vars['class'] = $ir->ask(
        \sprintf('Class for "%s" bundle', $bundles[$bundle_id]),
        '{bundle_id|camelize}Bundle',
      );
      $vars['class_fqn'] = '\\' . $vars['namespace'] . '\\' . $vars['class'];
      $assets->addFile('src/Entity/Bundle/{class}.php', 'bundle-class.twig')->vars($vars);
      // Track all bundle classes to generate hook_entity_bundle_info_alter().
      $vars['classes'][$bundle_id] = $vars['class'];
      $vars['classes_fqn'][$bundle_id] = $vars['class_fqn'];
    }

    $vars['base_class'] = FALSE;
    if ($ir->confirm('Use a base class?', FALSE)) {
      $vars['base_class'] = $ir->ask('Base class', '{entity_type_id|camelize}Bundle');
      $assets->addFile('src/Entity/Bundle/{base_class}.php', 'bundle-base-class.twig');
    }

    // @todo Handle duplicated hooks.
    $assets->addFile('{machine_name}.module', 'module.twig')
      ->appendIfExists(7);
  }

}
