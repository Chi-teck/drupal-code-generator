<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * Implements controller command.
 */
#[AsCommand('controller', 'Generates a controller')]
final class Controller extends Generator {

  protected string $templatePath = Application::TEMPLATE_PATH . '/controller';
  protected ?int $extensionType = DrupalGenerator::EXTENSION_TYPE_MODULE;
  protected bool $isNewExtension = FALSE;

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $interviewer = $this->createInterviewer($vars);

    $vars['machine_name'] = $interviewer->askMachineName();
    $vars['name'] = '{machine_name|m2h}';
    $vars['class'] = $interviewer->ask('Class', '{machine_name|camelize}Controller');

    $vars['services'] = $interviewer->askServices(FALSE);

    if ($interviewer->confirm('Would you like to create a route for this controller?')) {
      $vars['route_name'] = $interviewer->ask('Route name', '{machine_name}.example');
      $vars['route_path'] = $interviewer->ask('Route path', '/{machine_name|u2h}/example');
      $vars['route_title'] = $interviewer->ask('Route title', 'Example');
      $vars['route_permission'] = $interviewer->ask('Route permission', 'access content');
      $assets->addFile('{machine_name}.routing.yml', 'route.twig')->appendIfExists();
    }

    $assets->addFile('src/Controller/{class}.php', 'controller.twig');
  }

}
