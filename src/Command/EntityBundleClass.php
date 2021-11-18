<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use DrupalCodeGenerator\Application;

/**
 * Implements entity-bundle-class command.
 *
 * @todo Create a test.
 */
final class EntityBundleClass extends ModuleGenerator {

  /**
   * {@inheritdoc}
   *
   * @todo Move under 'entity' namespace?
   */
  protected string $name = 'entity-bundle-class';
  protected string $description = 'Generate a bundle class for a content entity.';
  protected string $templatePath = Application::TEMPLATE_PATH . '/entity-bundle-class';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {

    // @todo Figure out how to hide generators that cannot run without Drupal context.
    if (!$this->drupalContext) {
      $this->io->error('This command requires a fully bootstrapped Drupal instance.');
      return;
    }

    $this->collectDefault($vars);
    $vars['namespace'] = 'Drupal\\' . $vars['machine_name'] . '\Entity\Bundle';

    /** @var \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager */
    $entity_type_manager = $this->drupalContext->getContainer()->get('entity_type.manager');
    $definitions = \array_filter(
      $entity_type_manager->getDefinitions(),
      static fn (EntityTypeInterface $definition): bool => $definition->getGroup() === 'content',
    );

    $entity_type_choices = \array_map(
      static fn (ContentEntityTypeInterface $definition): string => (string) $definition->get('label'),
      $definitions,
    );
    $vars['entity_type_id'] = $this->choice('Entity type', $entity_type_choices);

    // @todo Should this use 'original_class' instead?
    $vars['entity_class_fqn'] = $definitions[$vars['entity_type_id']]->get('class');
    $vars['entity_class'] = \array_slice(\explode('\\', $vars['entity_class_fqn']), -1)[0];

    /** @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface $bundle_info */
    $bundle_info = $this->drupalContext->getContainer()->get('entity_type.bundle.info');
    $bundle_choices = \array_map(
      static fn (array $bundle): string => (string) $bundle['label'],
      $bundle_info->getBundleInfo($vars['entity_type_id']),
    );
    $vars['bundle_id'] = $this->choice('Bundle', $bundle_choices);

    $vars['class'] = $this->ask('Class', '{bundle_id|camelize}Bundle');
    $vars['class_fqn'] = '\\' . $vars['namespace'] . '\\' . $vars['class'];

    if ($this->confirm('Would you like to generate a base class?', FALSE)) {
      $vars['base_class'] = $this->ask('Base class', '{entity_type_id|camelize}Bundle');
      $this->addFile('src/Entity/Bundle/{base_class}.php', 'bundle-base-class');
    }

    $this->addFile('src/Entity/Bundle/{class}.php', 'bundle-class');

    // @todo Handle duplicated hooks.
    $this->addFile('{machine_name}.module', 'module.twig')
      ->appendIfExists()
      ->headerSize(7);
  }

}
