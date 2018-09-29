<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Service;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:service:cache-context command.
 */
class CacheContext extends BaseGenerator {

  protected $name = 'd8:service:cache-context';
  protected $description = 'Generates a cache context service';
  protected $alias = 'cache-context';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['context_id'] = new Question('Context ID', 'example');
    $default_class = function ($vars) {
      return Utils::camelize($vars['context_id']) . 'CacheContext';
    };
    $questions['class'] = new Question('Class', $default_class);
    $base_class_choices = [
      '-',
      'RequestStackCacheContextBase',
      'UserCacheContextBase',
    ];
    $questions['base_class'] = new ChoiceQuestion('Base class', $base_class_choices);
    $questions['calculated'] = new ConfirmationQuestion('Make the context calculated?', FALSE);

    $vars = &$this->collectVars($input, $output, $questions);
    $vars['context_label'] = Utils::machine2human($vars['context_id']);

    $vars['interface'] = $vars['calculated'] ?
      'CalculatedCacheContextInterface' : 'CacheContextInterface';

    if ($vars['base_class'] == '-') {
      $vars['base_class'] = FALSE;
    }

    $this->addFile()
      ->path('src/Cache/Context/{class}.php')
      ->template('d8/service/cache-context.twig');

    $this->addServicesFile()
      ->template('d8/service/cache-context.services.twig');
  }

}
