<?php

namespace DrupalCodeGenerator\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputOption;

/**
 * Implements generate command.
 *
 * @TODO: Create a test for this.
 */
class Navigation extends Command {

  protected $name = 'navigation';
  protected $description = 'Navigation';
  protected $activeMenuItems = [];
  protected $menuTree;

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName($this->name)
      ->setDescription($this->description)
      ->addOption(
        'destination',
        '-d',
        InputOption::VALUE_OPTIONAL,
        'Destination directory'
      );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    $style = new OutputFormatterStyle('black', 'cyan', []);
    $output->getFormatter()->setStyle('title', $style);

    $first_argument = $input->getFirstArgument();

    $this->activeMenuItems = $first_argument == $this->name ?
      [] : explode(':', $first_argument);

    /** @var \DrupalCodeGenerator\Commands\BaseGenerator $generator_name */
    $generator_name = $this->selectGenerator($input, $output);
      if (!$generator_name) {
      return 0;
    }

    $command = $this->getApplication()->find($generator_name);

    $header = sprintf('<info>Command:</info> <comment>%s</comment>', $generator_name);
    $output->writeln($header);
    $output->writeLn(str_repeat('<comment>-</comment>', strlen(strip_tags($header))));

    // Run generator.
    return $command->run($input, $output);
  }

  /**
   * Returns a generator selected by the user from a multilevel console menu.
   */
  protected function selectGenerator(InputInterface $input, OutputInterface $output) {

    $active_menu_tree = $this->menuTree;
    foreach ($this->activeMenuItems as $menuItem) {
      $active_menu_tree = $active_menu_tree[$menuItem];
    }

    if (is_array($active_menu_tree)) {

      // First menu item is used to return back into the parent menu item.
      $active_menu_tree = ['..' => NULL] + $active_menu_tree;

      $choices = [];
      foreach ($active_menu_tree as $menu_item => $subtree) {
        // We build $choices as an associative array to be able to find
        // later menu items by respective labels.
        $choices[$menu_item] = $this->createMenuItemLabel($menu_item, is_array($subtree));
      }

      $question = new ChoiceQuestion(
        '<title>Select generator:</title>',
        array_values($choices)
      );
      $question->setPrompt('  >>> ');
      $answer_label = $this->getHelper('question')->ask($input, $output, $question);
      $answer = array_search($answer_label, $choices);

      if ($answer == '..') {
        // Exit the application if the user choices zero key
        // on the top menu level.
        if (count($this->activeMenuItems) == 0) {
          return NULL;
        }
        // Set the menu one level higher.
        array_pop($this->activeMenuItems);
      }
      else {
        // Set the menu one level deeper.
        $this->activeMenuItems[] = $answer;
      }

      return $this->selectGenerator($input, $output);
    }
    else {
      return implode(':', $this->activeMenuItems);
    }

  }

  /**
   * Creates a human readable label for a given menu item.
   *
   * @param string $menu_item
   * @param bool $comment
   *
   * @return mixed|string
   */
  protected function createMenuItemLabel($menu_item, $comment) {
    // Some labels require individual approach.
    $labels = [
      'settings.php' => 'settings.php',
      'd6' => 'Drupal 6',
      'd7' => 'Drupal 7',
      'd8' => 'Drupal 8',
      'js-file' => 'Javascript file',
      'html-page' => 'HTML page',
    ];

    $label = isset($labels[$menu_item]) ?
      $labels[$menu_item] : str_replace(['-', '_'], ' ',  ucfirst($menu_item));

    return $comment ? "<comment>$label</comment>" : $label;
  }

  /**
   * Initialize generators navigation.
   *
   * @param Command[] $commands
   */
  public function init($commands) {
    $this->menuTree = [];
    $aliases = [];
    foreach ($commands as $index => $command) {
      $command_name = $command->getName();
      $command_subnames = explode(':', $command_name);

      $this->arraySetNestedValue($this->menuTree, $command_subnames, TRUE);

      // Last subname is actual command name so it should not be used as
      // an alias for navigation command.
      array_pop($command_subnames);

      $alias = '';
      foreach ($command_subnames as $key => $subname) {
        $alias = $alias .  ':' . $subname;
        $aliases[] = ltrim($alias, ':');
      }

    }

    $this->recursiveKsort($this->menuTree);
    $this->setAliases(array_unique($aliases));
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
        $ref = array();
      }
      $ref = &$ref[$parent];
    }
    if (!isset($ref)) {
      $ref = $value;
    }
  }

}
