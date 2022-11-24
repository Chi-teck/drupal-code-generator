<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Plugin;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Plugin\Context\ContextRepositoryInterface;
use Drupal\Core\TypedData\TypedDataManagerInterface;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Generator(
  name: 'plugin:condition',
  description: 'Generates condition plugin',
  aliases: ['condition'],
  templatePath: Application::TEMPLATE_PATH . '/Plugin/_condition',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Condition extends BaseGenerator implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    private readonly ContextRepositoryInterface $contextRepository,
    private readonly TypedDataManagerInterface $typedDataManager,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('context.repository'),
      $container->get('typed_data_manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['plugin_label'] = $ir->askPluginLabel();
    $vars['plugin_id'] = $ir->askPluginId();
    $vars['class'] = $ir->askPluginClass();
    $vars['services'] = $ir->askServices(FALSE);
    $assets->addFile('src/Plugin/Condition/{class}.php', 'condition.twig');
    $assets->addSchemaFile()->template('schema.twig');
  }

}
