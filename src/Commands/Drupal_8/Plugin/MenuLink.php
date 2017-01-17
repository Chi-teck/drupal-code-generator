<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Plugin;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:plugin:menu-link command.
 */
class MenuLink extends BaseGenerator {

  protected $name = 'd8:plugin:menu-link';
  protected $description = 'Generates menu-link plugin';
  protected $alias = 'menu-link';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'machine_name' => ['Module machine name'],
      'class' => [
        'Class',
        function ($vars) {
          return Utils::human2class($vars['name']) . 'MenuLink';
        },
      ],
    ];

    $vars = $this->collectVars($input, $output, $questions);

    $path = 'src/Plugin/Menu/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/plugin/menu-link.twig', $vars);
  }

}
