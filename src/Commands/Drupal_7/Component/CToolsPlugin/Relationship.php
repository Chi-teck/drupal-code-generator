<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component\CToolsPlugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Implements generate:d7:component:ctools-plugin:relationship command.
 */
class Relationship extends BasePlugin {

  protected static $name = 'generate:d7:component:ctools-plugin:relationship';
  protected static $description = 'Generate CTools relationship plugin';
  protected $template = 'd7/ctools-relationship-plugin.twig';

}
