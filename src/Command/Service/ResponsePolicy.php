<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:response-policy command.
 */
final class ResponsePolicy extends ModuleGenerator {

  protected string $name = 'service:response-policy';
  protected string $description = 'Generates a response policy service';
  protected string $alias = 'response-policy';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/response-policy';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', 'Example');
    $this->addFile('src/PageCache/{class}.php', 'response-policy');
    $this->addServicesFile()->template('services');
  }

}
