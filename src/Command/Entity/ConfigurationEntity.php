<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Entity;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\Asset;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Asset\Resolver\ResolverInterface;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'entity:configuration',
  description: 'Generates configuration entity',
  aliases: ['config-entity'],
  templatePath: Application::TEMPLATE_PATH . '/Entity/_configuration-entity',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class ConfigurationEntity extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['entity_type_label'] = $ir->ask('Entity type label', '{name}');
    $vars['entity_type_id'] = $ir->ask('Entity type ID', '{entity_type_label|h2m}');
    $vars['class_prefix'] = '{entity_type_id|camelize}';

    $assets->addFile('src/{class_prefix}ListBuilder.php', 'src/ExampleListBuilder.php.twig');
    $assets->addFile('src/Form/{class_prefix}Form.php', 'src/Form/ExampleForm.php.twig');
    $assets->addFile('src/{class_prefix}Interface.php', 'src/ExampleInterface.php.twig');
    $assets->addFile('src/Entity/{class_prefix}.php', 'src/Entity/Example.php.twig');
    $assets->addFile('{machine_name}.routing.yml', 'model.routing.yml.twig')
      ->appendIfExists();
    $assets->addFile('{machine_name}.links.action.yml', 'model.links.action.yml.twig')
      ->appendIfExists();
    $assets->addFile('{machine_name}.links.menu.yml', 'model.links.menu.yml.twig')
      ->appendIfExists();
    $assets->addFile('{machine_name}.permissions.yml', 'model.permissions.yml.twig')
      ->appendIfExists();
    $assets->addFile('config/schema/{machine_name}.schema.yml', 'config/schema/model.schema.yml.twig')
      ->appendIfExists();

    $assets->addFile('{machine_name}.info.yml.twig')
      ->setVirtual(TRUE)
      ->resolver($this->getInfoResolver($vars));
  }

  /**
   * Returns resolver for the module info file.
   */
  private function getInfoResolver(array $vars): ResolverInterface {
    // Add 'configure' link to the info file if it exists.
    return new class ($vars) implements ResolverInterface {

      public function __construct(private readonly array $vars) {}

      public function resolve(Asset $asset, string $path): Asset {
        if (!$asset instanceof File) {
          throw new \InvalidArgumentException('Wrong asset type.');
        }
        $resolved = clone $asset;
        $existing_content = \file_get_contents($path);
        if (!\preg_match('/^configure: /m', $existing_content)) {
          /** @psalm-suppress PossiblyUndefinedStringArrayOffset */
          $content = "{$existing_content}configure: entity.{$this->vars['entity_type_id']}.collection\n";
          return $resolved->content($content);
        }
        return $resolved;
      }

    };
  }

}
