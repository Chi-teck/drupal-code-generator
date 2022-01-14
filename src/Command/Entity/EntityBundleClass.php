<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Entity;

use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements entity-bundle-class command.
 *
 * @todo Create a test.
 */
final class EntityBundleClass extends ModuleGenerator {

  /**
   * {@inheritdoc}
   */
  protected string $name = 'entity:bundle-class';
  protected string $description = 'Generate a bundle class for a content entity.';
  protected string $templatePath = Application::TEMPLATE_PATH . '/entity-bundle-class';
  protected string $alias = 'bundle-class';

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    // @todo Figure out how to hide generators that cannot run without Drupal context.
    if (!$this->drupalContext) {
      $this->io->getErrorStyle()->error('This command requires a fully bootstrapped Drupal instance.');
      return 1;
    }
    return parent::execute($input, $output);
  }

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {

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
    $bundles = \array_map(
      static fn (array $bundle): string => (string) $bundle['label'],
      $bundle_info->getBundleInfo($vars['entity_type_id']),
    );

    // Skip the question when only 1 bundle exists.
    if (\count($bundles) === 1) {
      $vars['bundle_ids'] = \array_keys($bundles);
    }
    else {
      // Prepend an 'All' choice for user's convenience.
      $bundle_choices = ['' => 'All'] + $bundles;
      $vars['bundle_ids'] = $this->choice('Bundles, comma separated', $bundle_choices, NULL, TRUE);
      if (\in_array('', $vars['bundle_ids'])) {
        if (\count($vars['bundle_ids']) >= 2) {
          throw new \UnexpectedValueException("'All' may not be combined with other choices.");
        }
        // Replace 'all' with all bundle IDs.
        $vars['bundle_ids'] = \array_keys($bundles);
      }
    }

    $vars['classes'] = [];
    $vars['classes_fqn'] = [];
    foreach ($vars['bundle_ids'] as $bundle_id) {
      $vars['bundle_id'] = $bundle_id;
      $vars['class'] = $this->ask(
        \sprintf('Class for %s bundle', $bundles[$bundle_id]),
        '{bundle_id|camelize}Bundle',
      );
      $vars['class_fqn'] = '\\' . $vars['namespace'] . '\\' . $vars['class'];
      $this->addFile('src/Entity/Bundle/{class}.php', 'bundle-class')->vars($vars);
      // Track all bundle classes to generate hook_entity_bundle_info_alter().
      $vars['classes'][$bundle_id] = $vars['class'];
      $vars['classes_fqn'][$bundle_id] = $vars['class_fqn'];
    }

    if ($this->confirm('Use a base class?', FALSE)) {
      $vars['base_class'] = $this->ask('Base class', '{entity_type_id|camelize}Bundle');
      $this->addFile('src/Entity/Bundle/{base_class}.php', 'bundle-base-class');
    }

    // @todo Handle duplicated hooks.
    $this->addFile('{machine_name}.module', 'module.twig')
      ->appendIfExists()
      ->headerSize(7);
  }

}
