<?php

namespace DrupalCodeGenerator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Implements generate command.
 */
class Navigation extends Command {

  /**
   * Menu tree.
   *
   * @var array
   */
  protected $menuTree;

  /**
   * Name of the generator to execute.
   *
   * @var string
   */
  protected $generatorName;

  /**
   * Command labels.
   *
   * @var array
   */
  protected $labels = [
    'd7' => 'Drupal 7',
    'd8' => 'Drupal 8',
  ];

  /**
   * Aliases for some sub-menus.
   *
   * @var array
   */
  protected $defaultAliases = [
    'service' => 'd8:service',
    'plugin' => 'd8:plugin',
    'theme' => 'd8:theme',
    'module' => 'd8:module',
    'form' => 'd8:form',
    'test' => 'd8:test',
    'yml' => 'd8:yml',
    'links' => 'd8:yml:links',
  ];

  /**
   * Constructs menu command.
   *
   * @param \DrupalCodeGenerator\Command\GeneratorInterface[] $commands
   *   List of registered commands.
   */
  public function __construct(array $commands) {
    parent::__construct(NULL);

    // Initialize the menu structure.
    $this->menuTree = [];
    $aliases = array_keys($this->defaultAliases);

    // Build aliases for the navigation based on command namespaces.
    foreach ($commands as $command) {
      $command_name = $command->getName();
      $sub_names = explode(':', $command_name);

      $this->arraySetNestedValue($this->menuTree, $sub_names, TRUE);

      // The last sub-name is actual command name so it cannot be used as an
      // alias for navigation command.
      $last_sub_name = array_pop($sub_names);

      // Collect command labels.
      if ($label = $command->getLabel()) {
        $this->labels[$last_sub_name] = $label;
      }

      // We cannot use $application->getNamespaces() here because the
      // application is not available at this point.
      $alias = '';
      foreach ($sub_names as $sub_name) {
        $alias = $alias ? $alias . ':' . $sub_name : $sub_name;
        $aliases[] = $alias;
      }
    }

    $this->setAliases(array_unique($aliases));
    $this->recursiveKsort($this->menuTree);
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('navigation')
      ->setDescription('Provides an interactive menu to select generator')
      ->setHidden(TRUE)
      ->addOption(
        'directory',
        '-d',
        InputOption::VALUE_OPTIONAL,
        'Working directory'
      )
      ->addOption(
        'answers',
        '-a',
        InputOption::VALUE_OPTIONAL,
        'Default JSON formatted answers'
      );
  }

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $style = new OutputFormatterStyle('black', 'cyan', []);
    $output->getFormatter()->setStyle('title', $style);

    $command_name = $input->getFirstArgument();

    // Before version 3.3.6 of Symfony console getFistArgument returned default
    // command name.
    $command_name = $command_name == 'navigation' ? NULL : $command_name;

    if (isset($this->defaultAliases[$command_name])) {
      $command_name = $this->defaultAliases[$command_name];
    }

    $menu_trail = $command_name ? explode(':', $command_name) : [];

    $this->generatorName = $this->selectGenerator($input, $output, $menu_trail);
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    if (!$this->generatorName) {
      return 0;
    }

    // Run the generator.
    return $this->getApplication()
      ->find($this->generatorName)
      ->run($input, $output);
  }

  /**
   * Returns a generator selected by the user from a multilevel console menu.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param array $menu_trail
   *   Menu trail.
   *
   * @return string|null
   *   Generator name or null if user decided to exit the navigation.
   */
  protected function selectGenerator(InputInterface $input, OutputInterface $output, array $menu_trail) {

    // Narrow down menu tree.
    $active_menu_tree = $this->menuTree;
    foreach ($menu_trail as $active_menu_item) {
      $active_menu_tree = $active_menu_tree[$active_menu_item];
    }

    // The $active_menu_tree can be either an array of menu items or TRUE if the
    // user reached the final menu point.
    if ($active_menu_tree === TRUE) {
      return implode(':', $menu_trail);
    }

    $sub_menu_labels = $command_labels = [];
    foreach ($active_menu_tree as $menu_item => $subtree) {
      if (is_array($subtree)) {
        $sub_menu_labels[$menu_item] = $this->createMenuItemLabel($menu_item, TRUE);
      }
      else {
        $command_labels[$menu_item] = $this->createMenuItemLabel($menu_item, FALSE);
      }
    }
    asort($sub_menu_labels);
    asort($command_labels);

    // Generally the choices array consists of the following parts:
    // - Reference to the parent menu level.
    // - Sorted list of nested menu levels.
    // - Sorted list of commands.
    $choices = ['..' => '..'] + $sub_menu_labels + $command_labels;
    $question = new ChoiceQuestion('<title> Select generator: </title>', array_values($choices));
    $question->setPrompt(count($choices) <= 10 ? '  ➤➤➤ ' : '  ➤➤➤➤ ');

    $answer_label = $this->getHelper('question')->ask($input, $output, $question);
    $answer = array_search($answer_label, $choices);

    if ($answer == '..') {
      // Exit the application if the user selected zero on the top menu level.
      if (count($menu_trail) == 0) {
        return NULL;
      }
      // Decrease menu level.
      array_pop($menu_trail);
    }
    else {
      // Increase menu level.
      $menu_trail[] = $answer;
    }

    return $this->selectGenerator($input, $output, $menu_trail);
  }

  /**
   * Creates a human readable label for a given menu item.
   *
   * @param string $menu_item
   *   Machine name of the menu item.
   * @param bool $comment
   *   A boolean indicating that the label should be wrapped with comment tag.
   *
   * @return string
   *   The menu label.
   */
  protected function createMenuItemLabel($menu_item, $comment) {
    $label = isset($this->labels[$menu_item]) ?
      $this->labels[$menu_item] : str_replace(['-', '_'], ' ', ucfirst($menu_item));
    return $comment ? "<comment>$label</comment>" : $label;
  }

  /**
   * Sort multi-dimensional array by keys.
   *
   * @param array $array
   *   An array being sorted.
   *
   * @return array
   *   Sorted array.
   */
  protected function recursiveKsort(array &$array) {
    foreach ($array as &$value) {
      if (is_array($value)) {
        $this->recursiveKsort($value);
      }
    }
    return ksort($array);
  }

  /**
   * Sets a value in a nested array with variable depth.
   *
   * @param array $array
   *   A reference to the array to modify.
   * @param array $parents
   *   An array of parent keys, starting with the outermost key.
   * @param mixed $value
   *   The value to set.
   *
   * @see https://api.drupal.org/api/drupal/includes!common.inc/function/drupal_array_set_nested_value/7
   */
  protected function arraySetNestedValue(array &$array, array $parents, $value) {
    $ref = &$array;
    foreach ($parents as $parent) {
      if (isset($ref) && !is_array($ref)) {
        $ref = [];
      }
      $ref = &$ref[$parent];
    }
    if (!isset($ref)) {
      $ref = $value;
    }
  }

}
