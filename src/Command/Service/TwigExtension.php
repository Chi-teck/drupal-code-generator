<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:twig-extension command.
 */
final class TwigExtension extends ModuleGenerator {

  protected string $name = 'service:twig-extension';
  protected string $description = 'Generates Twig extension service';
  protected string $alias = 'twig-extension';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/twig-extension';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}TwigExtension');
    $this->collectServices($vars);
    $this->addFile('src/{class}.php', 'twig-extension');
    $this->addServicesFile()->template('services');
  }

}
