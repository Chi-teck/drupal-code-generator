<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Test;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;

/**
 * Implements test:nightwatch command.
 */
final class Nightwatch extends ModuleGenerator {

  protected string $name = 'test:nightwatch';
  protected string $description = 'Generates a nightwatch test';
  protected string $alias = 'nightwatch-test';
  protected string $templatePath = Application::TEMPLATE_PATH . '/test/nightwatch';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['test_name'] = Utils::camelize($this->ask('Test name', 'example'), FALSE);
    $this->addFile('tests/src/Nightwatch/{test_name}Test.js', 'nightwatch');
  }

}
