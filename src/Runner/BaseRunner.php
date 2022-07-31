<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Runner;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Command\GenerateCompletion;
use DrupalCodeGenerator\Command\Navigation;
use DrupalCodeGenerator\GeneratorFactory;

/**
 * Base class for DCG runners.
 *
 * @todo Create a test for this.
 */
abstract class BaseRunner implements RunnerInterface {

  /**
   * Configures application commands.
   */
  protected function configureCommands(Application $application): void {
    $class_resolver = $application->getContainer()->get('class_resolver');
    $generator_factory = new GeneratorFactory($class_resolver);
    $generators = $generator_factory->getGenerators();
    $application->addCommands($generators);

    $application->add(new GenerateCompletion());
    $application->add(new Navigation());
    $application->setDefaultCommand('navigation');
  }

  /**
   * {@inheritDoc}
   */
  public function run(Application $application): int {
    $this->configureCommands($application);
    return $application->run();
  }

}
