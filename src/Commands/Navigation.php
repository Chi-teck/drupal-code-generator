<?php

namespace DrupalCodeGenerator\Commands;

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

  protected $activeMenuItems = [];
  protected $menuTree;
  protected $generatorName;

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('navigation')
      ->setDescription('Navigation')
      ->addOption(
        'destination',
        '-d',
        InputOption::VALUE_OPTIONAL,
        'Destination directory'
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
    $this->activeMenuItems = $command_name == $this->getName() ?
      [] : explode(':', $command_name);

    /** @var \DrupalCodeGenerator\Commands\BaseGenerator $generator_name */
    $this->generatorName = $this->selectGenerator($input, $output);

  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    if (!$this->generatorName) {
      return 0;
    }

    $command = $this->getApplication()->find($this->generatorName);
    $aliases = $command->getAliases();

    $header = sprintf(
      '<info>Command:</info> <comment>%s</comment>',
      // Display alias instead command name if possible.
      isset($aliases[0]) ? $aliases[0] : $this->generatorName
    );
    $output->writeln($header);
    $output->writeln(str_repeat('-', strlen(strip_tags($header))));

    // Run the generator.
    return $command->run($input, $output);
  }

  /**
   * Returns a generator selected by the user from a multilevel console menu.
   */
  protected function selectGenerator(InputInterface $input, OutputInterface $output) {

    // Narrow menu tree according to the active menu items.
    $active_menu_tree = $this->menuTree;
    foreach ($this->activeMenuItems as $active_menu_item) {
      $active_menu_tree = $active_menu_tree[$active_menu_item];
    }

    // The $active_menu_tree can be either an array of child menu items or
    // the TRUE value indicating that the user reached the final menu point and
    // active menu items contain the actual command name.
    if (is_array($active_menu_tree)) {

      $subtrees = $command_names = [];
      // We build $choices as an associative array to be able to find
      // later menu items by respective labels.
      foreach ($active_menu_tree as $menu_item => $subtree) {
        $menu_item_label = $this->createMenuItemLabel($menu_item, is_array($subtree));
        if (is_array($subtree)) {
          $subtrees[$menu_item] = $menu_item_label;
        }
        else {
          $command_names[$menu_item] = $menu_item_label;
        }

      }
      asort($subtrees);
      asort($command_names);

      // Generally the choices array consists of the following parts:
      // - Reference to the parent menu level.
      // - Sorted list of nested menu levels.
      // - Sorted list of commands.
      $choices = ['..' => '..'] + $subtrees + $command_names;

      $question = new ChoiceQuestion(
        '<title>Select generator:</title>',
        array_values($choices)
      );
      $question->setPrompt('  >>> ');
      $answer_label = $this->getHelper('question')->ask($input, $output, $question);
      $answer = array_search($answer_label, $choices);
      if (!$answer) {
        throw new \UnexpectedValueException(sprintf('"%s" menu item was not found', $answer_label));
      }

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
   *   Machine name of the menu item.
   * @param bool $comment
   *   A boolean indicating that the label should be wrapped with comment tag.
   *
   * @return mixed|string
   *   The menu label.
   */
  protected function createMenuItemLabel($menu_item, $comment) {
    // Some labels require individual approach.
    $labels = [
      'settings.php' => 'settings.php',
      'template.php' => 'template.php',
      'd6' => 'Drupal 6',
      'd7' => 'Drupal 7',
      'd8' => 'Drupal 8',
      'html-page' => 'HTML page',
      'install' => 'Install file',
      'module-info' => 'Info (module)',
      'theme-info' => 'Info (theme)',
      'dcg-command' => 'DCG command',
    ];

    $label = isset($labels[$menu_item]) ?
      $labels[$menu_item] : str_replace(['-', '_'], ' ', ucfirst($menu_item));

    return $comment ? "<comment>$label</comment>" : $label;
  }

  /**
   * Initialize menu structure.
   *
   * @param Command[] $commands
   *   List of registered commands.
   */
  public function init(array $commands) {
    $this->menuTree = [];
    $aliases = [];
    foreach ($commands as $index => $command) {
      $command_name = $command->getName();
      $command_subnames = explode(':', $command_name);

      $this->arraySetNestedValue($this->menuTree, $command_subnames, TRUE);

      // The last subname is actual command name so it should not be used as
      // an alias for navigation command.
      array_pop($command_subnames);

      // We cannot use $application->getNamespaces() here because
      // the application is not ready at this point.
      $alias = '';
      foreach ($command_subnames as $key => $subname) {
        $alias = $alias . ':' . $subname;
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
        $ref = [];
      }
      $ref = &$ref[$parent];
    }
    if (!isset($ref)) {
      $ref = $value;
    }
  }

}
