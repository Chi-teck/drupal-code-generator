<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Entity;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Resolver\ResolverInterface;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements configuration-entity command.
 */
final class ConfigurationEntity extends ModuleGenerator {

  protected string $name = 'entity:configuration';
  protected string $description = 'Generates configuration entity';
  protected string $alias = 'config-entity';
  protected string $templatePath = Application::TEMPLATE_PATH . '/configuration-entity';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['entity_type_label'] = $this->ask('Entity type label', '{name}');
    $vars['entity_type_id'] = $this->ask('Entity type ID', '{entity_type_label|h2m}');
    $vars['class_prefix'] = '{entity_type_id|camelize}';

    $this->addFile('src/{class_prefix}ListBuilder.php', 'src/ExampleListBuilder.php');
    $this->addFile('src/Form/{class_prefix}Form.php', 'src/Form/ExampleForm.php');
    $this->addFile('src/{class_prefix}Interface.php', 'src/ExampleInterface.php');
    $this->addFile('src/Entity/{class_prefix}.php', 'src/Entity/Example.php');
    $this->addFile('{machine_name}.routing.yml', 'model.routing.yml')
      ->appendIfExists();
    $this->addFile('{machine_name}.links.action.yml', 'model.links.action.yml')
      ->appendIfExists();
    $this->addFile('{machine_name}.links.menu.yml', 'model.links.menu.yml')
      ->appendIfExists();
    $this->addFile('{machine_name}.permissions.yml', 'model.permissions.yml')
      ->appendIfExists();
    $this->addFile('config/schema/{machine_name}.schema.yml', 'config/schema/model.schema.yml')
      ->appendIfExists();

    $this->addFile('{machine_name}.info.yml')
      ->resolver($this->getInfoResolver($vars));
  }

  /**
   * Returns resolver for the module info file.
   *
   * @todo Clean-up.
   */
  private function getInfoResolver(array $vars): ResolverInterface {
    // Add 'configure' link to the info file if it exists.
    return new class ($vars) implements ResolverInterface {

      public function __construct(private array $vars) {}

      public function supports(Asset $asset): bool {
        return $asset instanceof File;
      }

      public function resolve(Asset $asset, string $path): Asset {
        if (!$asset instanceof File) {
          throw new \InvalidArgumentException('Wrong asset type.');
        }
        $resolved = clone $asset;
        $existing_content = \file_get_contents($path);
        if ($existing_content && !\preg_match('/^configure: /m', $existing_content)) {
          $content = "{$existing_content}configure: entity.{$this->vars['entity_type_id']}.collection\n";
          $resolved->content($content);
          return $resolved;
        }
        return $resolved;
      }

    };
  }

}
