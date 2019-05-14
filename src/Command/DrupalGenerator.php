<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Base class for Drupal generators.
 */
abstract class DrupalGenerator extends Generator {

  /**
   * Name question.
   *
   * @var string|null
   */
  protected $nameQuestion = 'Extension name';

  /**
   * Machine name question.
   *
   * @var string|null
   */
  protected $machineNameQuestion = 'Extension machine name';

  /**
   * Indicates that generated code is a new Drupal extension.
   *
   * @var bool
   */
  protected $isNewExtension = FALSE;

  /**
   * Extension type (module, theme, profile).
   *
   * @var string|null
   */
  protected $extensionType;

  /**
   * Drupal context.
   *
   * @var \DrupalCodeGenerator\Helper\DrupalContext|null
   */
  protected $drupalContext;

  /**
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output) :void {
    parent::initialize($input, $output);

    if ($this->getHelperSet()->has('drupal_context')) {
      $this->drupalContext = $this->getHelper('drupal_context');
    };

    // Set working directory to extension root.
    if (!$this->isNewExtension) {
      $this->directory = Utils::getExtensionRoot($this->directory) ?: $this->directory;
    }
  }

  /**
   * Collects default variables.
   */
  protected function &collectDefault() :array {
    // If both name and machine_name questions are defined it is quite possible
    // that we can provide the extension name without interacting with a user.
    if (!$this->isNewExtension && $this->drupalContext && $this->nameQuestion && $this->machineNameQuestion) {
      $extensions = $this->getExtensionList();
      $this->vars['machine_name'] = $this->askMachineNameQuestion();
      $this->vars['name'] = $extensions[$this->vars['machine_name']] ?? Utils::machine2human($this->vars['machine_name']);
    }
    else {
      if ($this->nameQuestion) {
        $this->vars['name'] = $this->askNameQuestion();
      }
      if ($this->machineNameQuestion) {
        $this->vars['machine_name'] = $this->askMachineNameQuestion();
      }
    }
    return $this->vars;
  }

  /**
   * Asks name question.
   */
  protected function askNameQuestion() :string {
    $root_directory = basename(Utils::getExtensionRoot($this->directory) ?: $this->directory);
    $default_value = Utils::machine2human($root_directory);
    $name_question = new Question($this->nameQuestion, $default_value);
    $name_question->setValidator([__CLASS__, 'validateRequired']);
    if (!$this->isNewExtension && $extensions = $this->getExtensionList()) {
      $name_question->setAutocompleterValues($extensions);
    }
    return $this->io->askQuestion($name_question);
  }

  /**
   * Asks machine name question.
   */
  protected function askMachineNameQuestion() :string {
    $default_value = Utils::human2machine($this->vars['name'] ?? basename($this->directory));
    $machine_name_question = new Question($this->machineNameQuestion, $default_value);
    $machine_name_question->setValidator([__CLASS__, 'validateMachineName']);
    if (!$this->isNewExtension && $extensions = $this->getExtensionList()) {
      $machine_name_question->setAutocompleterValues(array_keys($extensions));
    }
    return $this->io->askQuestion($machine_name_question);
  }

  /**
   * Returns extension list.
   *
   * @return \Drupal\Core\Extension\Extension[]
   *   An associative array whose keys are the machine names of the extensions
   *   and whose values are extension names.
   */
  protected function getExtensionList() {
    return $this->drupalContext ? $this->drupalContext->getExtensionList($this->extensionType) : [];
  }

  /**
   * {@inheritdoc}
   */
  protected function getDestination() {
    if ($this->drupalContext && $this->extensionType) {
      $destination = $this->drupalContext->getDestination(
        $this->extensionType,
        $this->isNewExtension,
        $this->vars['machine_name'] ?? NULL
      );
    }
    return $destination ?? parent::getDestination();
  }

}
