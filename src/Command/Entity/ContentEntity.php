<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command\Entity;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Utils;

#[Generator(
  name: 'entity:content',
  description: 'Generates content entity',
  aliases: ['content-entity'],
  templatePath: Application::TEMPLATE_PATH . '/Entity/_content-entity',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class ContentEntity extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $vars['entity_type_label'] = $ir->ask('Entity type label', '{name}');
    // Make sure the default entity type ID is not like 'example_example'.
    // @todo Create a test for this.
    $default_entity_type_id = Utils::human2machine($vars['entity_type_label']) === $vars['machine_name'] ?
      $vars['machine_name'] : $vars['machine_name'] . '_' . Utils::human2machine($vars['entity_type_label']);
    $vars['entity_type_id'] = $ir->ask('Entity type ID', $default_entity_type_id);

    $vars['entity_type_id_short'] = $vars['machine_name'] === $vars['entity_type_id'] ?
      $vars['entity_type_id'] : Utils::removePrefix($vars['entity_type_id'], $vars['machine_name'] . '_');

    $vars['class'] = $ir->ask('Entity class', '{entity_type_label|camelize}');
    $vars['entity_base_path'] = $ir->ask('Entity base path', '/{entity_type_id_short|u2h}');
    $vars['fieldable'] = $ir->confirm('Make the entity type fieldable?');
    $vars['revisionable'] = $ir->confirm('Make the entity type revisionable?', FALSE);
    $vars['translatable'] = $ir->confirm('Make the entity type translatable?', FALSE);
    $vars['bundle'] = $ir->confirm('The entity type has bundle?', FALSE);
    $vars['canonical'] = $ir->confirm('Create canonical page?');
    $vars['template'] = $vars['canonical'] && $ir->confirm('Create entity template?');
    $vars['access_controller'] = $ir->confirm('Create CRUD permissions?', FALSE);

    $vars['label_base_field'] = $ir->confirm('Add "label" base field?');
    $vars['status_base_field'] = $ir->confirm('Add "status" base field?');
    $vars['created_base_field'] = $ir->confirm('Add "created" base field?');
    $vars['changed_base_field'] = $ir->confirm('Add "changed" base field?');
    $vars['author_base_field'] = $ir->confirm('Add "author" base field?');
    $vars['description_base_field'] = $ir->confirm('Add "description" base field?');
    $vars['has_base_fields'] = $vars['label_base_field'] ||
                               $vars['status_base_field'] ||
                               $vars['created_base_field'] ||
                               $vars['changed_base_field'] ||
                               $vars['author_base_field'] ||
                               $vars['description_base_field'];

    $vars['permissions']['administer'] = $vars['bundle']
      ? 'administer {entity_type_id} types' : 'administer {entity_type_id}';

    if ($vars['access_controller']) {
      $vars['permissions']['view'] = 'view {entity_type_id}';
      $vars['permissions']['edit'] = 'edit {entity_type_id}';
      $vars['permissions']['delete'] = 'delete {entity_type_id}';
      $vars['permissions']['create'] = 'create {entity_type_id}';
    }

    $vars['rest_configuration'] = $ir->confirm('Create REST configuration for the entity?', FALSE);

    if (!\str_starts_with($vars['entity_base_path'], '/')) {
      $vars['entity_base_path'] = '/' . $vars['entity_base_path'];
    }

    if (($vars['fieldable_no_bundle'] = $vars['fieldable'] && !$vars['bundle'])) {
      $vars['configure'] = 'entity.{entity_type_id}.settings';
    }
    elseif ($vars['bundle']) {
      $vars['configure'] = 'entity.{entity_type_id}_type.collection';
    }

    $vars['template_name'] = '{entity_type_id|u2h}.html.twig';

    // Contextual links need title suffix to be added to entity template.
    if ($vars['template']) {
      $assets->addFile('{machine_name}.links.contextual.yml', 'model.links.contextual.yml.twig')
        ->appendIfExists();
    }
    $assets->addFile('{machine_name}.links.action.yml', 'model.links.action.yml.twig')
      ->appendIfExists();
    $assets->addFile('{machine_name}.links.menu.yml', 'model.links.menu.yml.twig')
      ->appendIfExists();
    $assets->addFile('{machine_name}.links.task.yml', 'model.links.task.yml.twig')
      ->appendIfExists();
    $assets->addFile('{machine_name}.permissions.yml', 'model.permissions.yml.twig')
      ->appendIfExists();

    // Delete action plugins only registered for entity types that have
    // 'delete-multiple-confirm' form handler and 'delete-multiple-form' link
    // template.
    // @see \Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider::getDeleteMultipleFormRoute
    // @see \Drupal\Core\Action\Plugin\Action\Derivative\EntityDeleteActionDeriver
    $assets->addFile(
      'config/install/system.action.{entity_type_id}_delete_action.yml',
      'config/install/system.action.example_delete_action.yml.twig',
    );
    // Save action plugins only registered for entity types that implement
    // Drupal\Core\Entity\EntityChangedInterface.
    // @see \Drupal\Core\Action\Plugin\Action\Derivative\EntityChangedActionDeriver
    if ($vars['changed_base_field']) {
      $assets->addFile(
        'config/install/system.action.{entity_type_id}_save_action.yml',
        'config/install/system.action.example_save_action.yml.twig',
      );
    }

    $assets->addFile('src/Entity/{class}.php', 'src/Entity/Example.php.twig');
    $assets->addFile('src/{class}Interface.php', 'src/ExampleInterface.php.twig');

    if (!$vars['canonical']) {
      $assets->addFile('src/Routing/{class}HtmlRouteProvider.php', 'src/Routing/ExampleHtmlRouteProvider.php.twig');
    }

    $assets->addFile('src/{class}ListBuilder.php', 'src/ExampleListBuilder.php.twig');
    $assets->addFile('src/Form/{class}Form.php', 'src/Form/ExampleForm.php.twig');

    if ($vars['fieldable_no_bundle']) {
      $assets->addFile('{machine_name}.routing.yml', 'model.routing.yml.twig')
        ->appendIfExists();
      $assets->addFile('src/Form/{class}SettingsForm.php', 'src/Form/ExampleSettingsForm.php.twig');
    }

    if ($vars['template']) {
      $assets->addFile('templates/{entity_type_id|u2h}.html.twig', 'templates/model-example.html.twig.twig');
      $assets->addFile('{machine_name}.module', 'model.module.twig')
        ->appendIfExists(7);
    }

    if ($vars['access_controller']) {
      $assets->addFile('src/{class}AccessControlHandler.php', 'src/ExampleAccessControlHandler.php.twig');
    }

    if ($vars['rest_configuration']) {
      $assets->addFile('config/optional/rest.resource.entity.{entity_type_id}.yml', 'config/optional/rest.resource.entity.example.yml.twig');
    }

    if ($vars['bundle']) {
      $assets->addFile('config/schema/{machine_name}.entity_type.schema.yml', 'config/schema/model.entity_type.schema.yml.twig')
        ->appendIfExists();
      $assets->addFile('src/{class}TypeListBuilder.php', 'src/ExampleTypeListBuilder.php.twig');
      $assets->addFile('src/Entity/{class}Type.php', 'src/Entity/ExampleType.php.twig');
      $assets->addFile('src/Form/{class}TypeForm.php', 'src/Form/ExampleTypeForm.php.twig');
    }
  }

}
