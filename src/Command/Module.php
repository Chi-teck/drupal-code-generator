<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Extension\Exception\UnknownExtensionException;
use Drupal\Core\Extension\ModuleExtensionList;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Required;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Generator(
  name: 'module',
  description: 'Generates Drupal module',
  templatePath: Application::TEMPLATE_PATH . '/_module',
  type: GeneratorType::MODULE,
)]
final class Module extends BaseGenerator implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(
    private readonly ModuleExtensionList $moduleList,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self($container->get('extension.list.module'));
  }

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['name'] = $ir->askName();
    $vars['machine_name'] = $ir->askMachineName();

    $vars['description'] = $ir->ask('Module description', validator: new Required());
    $vars['package'] = $ir->ask('Package', 'Custom');

    $dependencies = $ir->ask('Dependencies (comma separated)');
    $vars['dependencies'] = $this->buildDependencies($dependencies);

    $assets->addFile('{machine_name}/{machine_name}.info.yml', 'model.info.yml.twig');

    if ($ir->confirm('Would you like to create module file?', FALSE)) {
      $assets->addFile('{machine_name}/{machine_name}.module', 'model.module.twig');
    }

    if ($ir->confirm('Would you like to create install file?', FALSE)) {
      $assets->addFile('{machine_name}/{machine_name}.install', 'model.install.twig');
    }

    if ($ir->confirm('Would you like to create README.md file?', FALSE)) {
      $assets->addFile('{machine_name}/README.md', 'README.md.twig');
    }
  }

  /**
   * Builds array of dependencies from comma-separated string.
   */
  private function buildDependencies(?string $dependencies_encoded): array {

    $dependencies = $dependencies_encoded ? \explode(',', $dependencies_encoded) : [];

    foreach ($dependencies as &$dependency) {
      $dependency = \str_replace(' ', '_', \trim(\strtolower($dependency)));
      // Check if the module name is already prefixed.
      if (\str_contains($dependency, ':')) {
        continue;
      }
      // Dependencies should be namespaced in the format {project}:{name}.
      $project = $dependency;
      try {
        // The extension list is internal for extending not for instantiating.
        // @see \Drupal\Core\Extension\ExtensionList
        /** @psalm-suppress InternalMethod */
        $package = $this->moduleList->getExtensionInfo($dependency)['package'] ?? NULL;
        if ($package === 'Core') {
          $project = 'drupal';
        }
      }
      catch (UnknownExtensionException) {

      }
      $dependency = $project . ':' . $dependency;
    }

    $dependency_sorter = static function (string $a, string $b): int {
      // Core dependencies go first.
      $a_is_drupal = \str_starts_with($a, 'drupal:');
      $b_is_drupal = \str_starts_with($b, 'drupal:');
      if ($a_is_drupal xor $b_is_drupal) {
        return $a_is_drupal ? -1 : 1;
      }
      return $a <=> $b;
    };
    \uasort($dependencies, $dependency_sorter);

    return $dependencies;
  }

}
