<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Yml;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Required;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * @todo Create tests.
 */
#[Generator(
  name: 'yml:migration',
  description: 'Generates a migration yml file',
  aliases: ['migration', 'migration.yml'],
  templatePath: Application::TEMPLATE_PATH . '/Yaml/_migration',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Migration extends BaseGenerator implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    private readonly EntityFieldManagerInterface $entityFieldManager,
    private readonly ContainerInterface $container,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('entity_field.manager'),
      $container,
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_label'] = $ir->askPluginLabel('Migration label');
    $vars['plugin_id'] = $ir->askPluginId('Migration ID');

    $question = new Question('Source plugin ID');
    $question->setValidator(new Required());
    try {
      $source_manager = $this->container->get('plugin.manager.migrate.source');
      $source_plugins = \array_keys($source_manager->getDefinitions());
      $question->setAutocompleterValues($source_plugins);
    }
    catch (ServiceNotFoundException) {
      // Migrate module is not installed.
    }
    $vars['source_plugin'] = $this->io()->askQuestion($question);

    $question = new Question('Destination plugin ID');
    $question->setValidator(new Required());
    try {
      $destination_manager = $this->container->get('plugin.manager.migrate.destination');
      $destination_plugins = \array_keys($destination_manager->getDefinitions());
      $question->setAutocompleterValues($destination_plugins);
    }
    catch (ServiceNotFoundException) {
      // Migrate module is not installed.
    }
    $vars['destination_plugin'] = $this->io()->askQuestion($question);

    $vars['fields'] = [];
    if (\str_starts_with($vars['destination_plugin'], 'entity:')) {
      [, $entity_type] = \explode('entity:', $vars['destination_plugin']);
      $field_map = $this->entityFieldManager->getFieldMap();
      $vars['fields'] = \array_keys($field_map[$entity_type] ?? []);
    }

    $assets->addFile('migration/{plugin_id}.yml', 'migration.twig');
  }

}
