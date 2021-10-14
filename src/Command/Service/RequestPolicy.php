<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Service;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements service:request-policy command.
 */
final class RequestPolicy extends ModuleGenerator {

  protected string $name = 'service:request-policy';
  protected string $description = 'Generates a request policy service';
  protected string $alias = 'request-policy';
  protected string $templatePath = Application::TEMPLATE_PATH . '/service/request-policy';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', 'Example');
    $this->addFile('src/PageCache/{class}.php', 'request-policy');
    $this->addServicesFile()->template('services');
  }

}
