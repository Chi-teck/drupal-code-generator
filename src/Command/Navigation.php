<?php

namespace DrupalCodeGenerator\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Implements navigation command.
 */
class Navigation extends Command {

  /**
   * Menu tree.
   *
   * @var array
   */
  protected $menuTree = [];

  /**
   * Command labels.
   *
   * @var array
   */
  protected $labels = [
    'd7' => 'Drupal 7',
    'yml' => 'Yaml',
  ];

  /**
   * {@inheritdoc}
   */
  protected function configure() {

    // As the navigation is default command the help should be relevant to the
    // entire DCG application.
    $help = [
      '<info>dcg</info>                          Display navigation',
      '<info>dcg d8:plugin:field:widget</info>   Run a specific generator',
      '<info>dcg list</info>                     List all available generators',
    ];

    $this
      ->setName('navigation')
      ->setDescription('Command line code generator')
      ->setHelp(implode("\n", $help) . "\n")
      ->setHidden(TRUE)
      ->addOption(
        'directory',
        '-d',
        InputOption::VALUE_OPTIONAL,
        'Working directory'
      );
  }

  /**
   * {@inheritdoc}
   */
  public function getSynopsis($short = FALSE) :string {
    return 'dcg [options] <generator>';
  }

  /**
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output) :void {
    parent::initialize($input, $output);

    // Initialize the menu structure.
    $this->menuTree = [];
    foreach ($this->getApplication()->all() as $command) {
      if (!$command instanceof GeneratorInterface) {
        continue;
      }
      $command_name = $command->getName();
      static::arraySetNestedValue($this->menuTree, explode(':', $command_name), TRUE);
      // Collect command labels.
      if ($label = $command->getLabel()) {
        $this->labels[$command_name] = $label;
      }
    }
    static::recursiveKsort($this->menuTree);

    $style = new OutputFormatterStyle('white', 'blue', ['bold']);
    $output->getFormatter()->setStyle('title', $style);
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) :?int {
    if ($command_name = $this->selectGenerator($input, $output)) {
      return $this->getApplication()
        ->find($command_name)
        ->run($input, $output);
    }
    return 0;
  }

  /**
   * Returns a generator selected by the user from a multilevel console menu.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param array $menu_trail
   *   (Optional) Menu trail.
   *
   * @return string|null
   *   Generator name or null if user decided to exit the navigation.
   */
  protected function selectGenerator(InputInterface $input, OutputInterface $output, array $menu_trail = []) :?string {

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
      $command_name = $menu_trail ? (implode(':', $menu_trail) . ':' . $menu_item) : $menu_item;
      if (is_array($subtree)) {
        $sub_menu_labels[$menu_item] = $this->createMenuItemLabel($command_name, TRUE);
      }
      else {
        $command_labels[$menu_item] = $this->createMenuItemLabel($command_name, FALSE);
      }
    }
    asort($sub_menu_labels);
    asort($command_labels);

    // Generally the choices array consists of the following parts:
    // - Reference to the parent menu level.
    // - Sorted list of nested menu levels.
    // - Sorted list of commands.
    $choices = ['..' => '..'] + $sub_menu_labels + $command_labels;
    $question = new ChoiceQuestion('<title> Select generator </title>', array_values($choices));

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
   * @param string $command_name
   *   Command name.
   * @param bool $nested
   *   A boolean indicating that the menu item has sub-items.
   *
   * @return string
   *   The menu item label.
   */
  protected function createMenuItemLabel(string $command_name, bool $nested) :string {

    if (isset($this->labels[$command_name])) {
      $label = $this->labels[$command_name];
    }
    else {
      $sub_names = explode(':', $command_name);
      $last_sub_name = array_pop($sub_names);
      $label = str_replace(['-', '_'], ' ', ucfirst($last_sub_name));
    }

    return $nested ? "<comment>$label</comment>" : $label;
  }

  /**
   * Sort multi-dimensional array by keys.
   *
   * @param array $array
   *   An array being sorted.
   */
  protected static function recursiveKsort(array &$array) :void {
    foreach ($array as &$value) {
      if (is_array($value)) {
        static::recursiveKsort($value);
      }
    }
    ksort($array);
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
  protected static function arraySetNestedValue(array &$array, array $parents, $value) :void {
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
