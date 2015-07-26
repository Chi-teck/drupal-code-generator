<?php

namespace DrupalCodeGenerator\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * Implements generate command.
 *
 * @TODO: Create a test for this.
 */
class Navigation extends Command {

  protected $name = 'generate';
  protected $description = 'Navigation';
  protected $activeMenuItems = [];
  protected $menuTree;


  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName($this->name)
      ->setDescription($this->description);
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    $style = new OutputFormatterStyle('black', 'cyan', []);
    $output->getFormatter()->setStyle('title', $style);

    $this->activeMenuItems = explode(':', $input->getFirstArgument());
    array_shift($this->activeMenuItems);

    /** @var \DrupalCodeGenerator\Commands\BaseGenerator $generator */
    $generator = $this->selectGenerator($input, $output);

    try {
      $command = $this->getApplication()->find($generator);
    }
    catch(\InvalidArgumentException $e) {
      $output->writeLn("<error>Sorry command $generator is not implemented yet.</error>");
      exit(1);
    }

    $output->writeln(sprintf('<info>Command:</info> <comment>%s</comment>', $command->getName()));
    $output->writeLn(str_repeat('<comment>-</comment>', 35));

    $command->run($input, $output);
  }

  /**
   *
   */
  protected function selectGenerator(InputInterface $input, OutputInterface $output) {

    $tree = $this->menuTree;
    foreach ($this->activeMenuItems as $menuItem) {
      $tree = $tree[strip_tags($menuItem)];
    }

    if (is_array($tree)) {

      // First menu item is used to move back into the parent menu item.
      $tree = ['..' => NULL] + $tree;

      $choices = [];
      foreach ($tree as $menu_item => $subtree) {
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
        // on the top level menu.
        if (count($this->activeMenuItems) == 0) {
          exit;
        }
        array_pop($this->activeMenuItems);
      }
      else {
        $this->activeMenuItems[] = $answer;
      }

      return $this->selectGenerator($input, $output);
    }
    else {
      return 'generate:' . implode(':', $this->activeMenuItems);
    }

  }

  /**
   * @param $menu_item
   * @param $comment
   * @return mixed|string
   */
  protected function createMenuItemLabel($menu_item, $comment) {
    $label = preg_replace('#^d([6-8])$#', 'Drupal_$1', $menu_item);
    $label = ucfirst($label);
    $label = str_replace(['-', '_'], ' ', $label);
    return $comment ? "<comment>$label</comment>" : $label;
  }

  /**
   * Initialize generators navigation.
   */
  public function init($commands) {
    $this->menuTree = [];
    $aliases = [];
    foreach ($commands as $index => $command) {
      $command_name = $command->getName();
      $command_subnames = explode(':', $command_name);
      if ($command_subnames[0] == 'generate') {
        unset($command_subnames[0]);

        $alias = 'generate';
        foreach ($command_subnames as $key => $subname) {
          // Last subname is actual command name.
          if (isset($command_subnames[$key + 1])) {
            $alias = $alias .  ':' . $subname;
            $aliases[] = $alias;
          }
        }

        $this->arraySetNestedValue($this->menuTree, $command_subnames, TRUE);
      }
    }

    $this->recursiveKsort($this->menuTree);

    $this->setAliases(array_unique($aliases));
  }

  /**
   *
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
