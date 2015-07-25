<?php

namespace DrupalCodeGenerator\Commands\Drupal_7\Component\CToolsPlugin;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Implements generate:d7:component:ctools-plugin:content-type command.
 */
class ContentType extends BasePlugin {

  protected static $name = 'generate:d7:component:ctools-plugin:content-type';
  protected static $description = 'Generate CTools content type plugin';
  protected $template = 'd7/ctools-content-type-plugin.twig';

}
