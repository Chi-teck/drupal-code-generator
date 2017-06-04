<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:service:twig-extension command.
 */
class TwigExtension extends BaseGenerator {

  protected $name = 'd8:service:twig-extension';
  protected $description = 'Generates Twig extension service';
  protected $alias = 'twig-extension';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions() + [
      'class' => [
        'Class',
        function ($vars) {
          return Utils::camelize($vars['name'] . 'TwigExtension');
        },
      ],
    ];
    $vars = $this->collectVars($input, $output, $questions);

    $path = 'src/' . $vars['class'] . '.php';
    $this->files[$path] = $this->render('d8/service/twig-extension.twig', $vars);
    $this->setServicesFile($vars['machine_name'] . '.services.yml', 'd8/service/twig-extension.services.twig', $vars);
  }

}
