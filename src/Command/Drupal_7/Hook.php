<?php

namespace DrupalCodeGenerator\Command\Drupal_7;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d7:hook command.
 */
class Hook extends BaseGenerator {

  protected $name = 'd7:hook';
  protected $description = 'Generates a hook';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['hook_name'] = new Question('Hook name');
    $questions['hook_name']->setValidator(function ($value) {
      if (!in_array($value, $this->getSupportedHooks())) {
        throw new \UnexpectedValueException('The value is not correct class name.');
      }
      return $value;
    });
    $questions['hook_name']->setAutocompleterValues($this->getSupportedHooks());

    $vars = $this->collectVars($input, $output, $questions);

    $install_hooks = [
      'install',
      'uninstall',
      'enable',
      'disable',
      'schema',
      'schema_alter',
      'field_schema',
      'requirements',
      'update_N',
      'update_last_removed',
    ];

    $file_type = in_array($vars['hook_name'], $install_hooks) ? 'install' : 'module';

    $this->addFile()
      ->path("{machine_name}.$file_type")
      ->headerTemplate("d7/file-docs/$file_type.twig")
      ->template('d7/hook/' . $vars['hook_name'] . '.twig')
      ->action('append')
      ->headerSize(7);
  }

  /**
   * Gets list of supported hooks.
   *
   * @return array
   *   List of supported hooks.
   */
  protected function getSupportedHooks() {
    return array_map(function ($file) {
      return pathinfo($file, PATHINFO_FILENAME);
    }, array_diff(scandir($this->templatePath . '/d7/hook'), ['.', '..']));
  }

}
