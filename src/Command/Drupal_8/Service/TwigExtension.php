<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:twig-extension command.
 */
class TwigExtension extends ModuleGenerator {

  protected $name = 'd8:service:twig-extension';
  protected $description = 'Generates Twig extension service';
  protected $alias = 'twig-extension';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $questions = Utils::moduleQuestions();
    $default_class = function ($vars) {
      return Utils::camelize($vars['name']) . 'TwigExtension';
    };
    $questions['class'] = new Question('Class', $default_class);
    $this->collectVars($questions);

    if ($this->confirm('Would you like to inject dependencies?')) {
      $this->collectServices();
    }

    $this->addFile()
      ->path('src/{class}.php')
      ->template('d8/service/twig-extension.twig');

    $this->addServicesFile()
      ->template('d8/service/twig-extension.services.twig');
  }

}
