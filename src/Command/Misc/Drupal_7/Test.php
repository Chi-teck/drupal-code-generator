<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\ModuleGenerator;

/**
 * Implements misc:d7:test command.
 */
final class Test extends ModuleGenerator {

  protected string $name = 'misc:d7:test';
  protected string $description = 'Generates Drupal 7 test case';
  protected string $templatePath = Application::TEMPLATE_PATH . '/misc/d7/test';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);
    $vars['class'] = $this->ask('Class', '{machine_name|camelize}TestCase');
    $this->addFile('{machine_name}.test', 'test');
  }

}
