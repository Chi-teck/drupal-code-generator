<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\InputOutput\DefaultOptions;
use DrupalCodeGenerator\InputOutput\IOAwareInterface;
use DrupalCodeGenerator\InputOutput\IOAwareTrait;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Implements navigation command.
 */
#[AsCommand(name: 'navigation')]
final class Navigation extends Command implements IOAwareInterface, LoggerAwareInterface {

  use IOAwareTrait;
  use LoggerAwareTrait;

  /**
   * Menu tree.
   *
   * @var array
   */
  private array $menuTree = [];

  /**
   * Menu labels.
   *
   * @var array
   */
  private array $labels = [
    'misc:d7' => 'Drupal 7',
    'yml' => 'Yaml',
    'misc' => 'Miscellaneous',
  ];

  /**
   * {@inheritdoc}
   */
  protected function configure(): void {

    // As the navigation is default command the help should be relevant to the
    // entire DCG application.
    $help = <<<'EOT'
      <info>dcg</info>                          Display navigation
      <info>dcg plugin:field:widget</info>      Run a specific generator
      <info>dcg list</info>                     List all available generators

    EOT;

    $this
      ->setName('navigation')
      ->setDescription('Command line code generator')
      ->setHelp($help)
      ->setHidden();
    DefaultOptions::apply($this);
  }

  /**
   * {@inheritdoc}
   */
  public function getSynopsis($short = FALSE): string {
    return 'dcg [options] <generator>';
  }

  /**
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output): void {
    parent::initialize($input, $output);

    // Build the menu structure.
    $this->menuTree = [];
    if (!$application = $this->getApplication()) {
      throw new \LogicException('Navigation command cannot work without application');
    }
    foreach ($application->all() as $command) {
      if ($command instanceof LabelInterface && !$command->isHidden()) {
        /** @var string $command_name */
        $command_name = $command->getName();
        self::arraySetNestedValue($this->menuTree, \explode(':', $command_name));
        // Collect command labels.
        if ($label = $command->getLabel()) {
          $this->labels[$command_name] = $label;
        }
      }
    }
    self::recursiveKsort($this->menuTree);

    $style = new OutputFormatterStyle('white', 'blue', ['bold']);
    $output->getFormatter()->setStyle('title', $style);
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {
    if ($command_name = $this->selectGenerator($input, $output)) {
      if (!$application = $this->getApplication()) {
        throw new \LogicException('Navigation command cannot work without application');
      }
      return $application
        ->find($command_name)
        ->run($input, $output);
    }
    return 0;
  }

  /**
   * Selects a generator.
   *
   * Returns a generator selected by the user from a multilevel console menu or
   * null if user decided to exit the navigation.
   */
  private function selectGenerator(InputInterface $input, OutputInterface $output, array $menu_trail = []): ?string {

    // Narrow down the menu tree using menu trail.
    $active_menu_tree = $this->menuTree;
    foreach ($menu_trail as $active_menu_item) {
      $active_menu_tree = $active_menu_tree[$active_menu_item];
    }

    // The $active_menu_tree can be either an array of menu items or TRUE if the
    // user has reached the final menu point.
    if ($active_menu_tree === TRUE) {
      return \implode(':', $menu_trail);
    }

    $sub_menu_labels = $command_labels = [];
    foreach ($active_menu_tree as $menu_item => $subtree) {
      $command_name = $menu_trail ? (\implode(':', $menu_trail) . ':' . $menu_item) : $menu_item;
      $label = $this->labels[$command_name] ?? \str_replace(['-', '_'], ' ', \ucfirst($menu_item));
      \is_array($subtree)
        ? $sub_menu_labels[$menu_item] = "<comment>$label</comment>"
        : $command_labels[$menu_item] = $label;
    }

    // Generally the choices array consists of the following parts:
    // - Reference to the parent menu level.
    // - Sorted list of nested menu levels.
    // - Sorted list of commands.
    \natcasesort($sub_menu_labels);
    \natcasesort($command_labels);
    $choices = ['..' => '..'] + $sub_menu_labels + $command_labels;
    $question = new ChoiceQuestion('<title> Select generator </title>', \array_values($choices));

    $answer_label = $this->getHelper('question')->ask($input, $output, $question);
    $answer = \array_search($answer_label, $choices);

    if ($answer === '..') {
      // Exit the application if a user selected zero on the top menu level.
      if (\count($menu_trail) === 0) {
        return NULL;
      }
      // Level up.
      \array_pop($menu_trail);
    }
    else {
      // Level down.
      $menu_trail[] = $answer;
    }

    return $this->selectGenerator($input, $output, $menu_trail);
  }

  /**
   * Sort multi-dimensional array by keys.
   *
   * @param array $array
   *   An array being sorted.
   */
  private static function recursiveKsort(array &$array): void {
    foreach ($array as &$value) {
      if (\is_array($value)) {
        self::recursiveKsort($value);
      }
    }
    \ksort($array);
  }

  /**
   * Sets the property to true in nested array.
   *
   * @psalm-param list<string> $parents
   *   An array of parent keys, starting with the outermost key.
   *
   * @see https://api.drupal.org/api/drupal/includes!common.inc/function/drupal_array_set_nested_value/7
   */
  private static function arraySetNestedValue(array &$array, array $parents): void {
    $ref = &$array;
    foreach ($parents as $parent) {
      if (isset($ref) && !\is_array($ref)) {
        $ref = [];
      }
      // @todo Fix this.
      /** @psalm-suppress PossiblyNullArrayAccess */
      $ref = &$ref[$parent];
    }
    $ref ??= TRUE;
  }

}
