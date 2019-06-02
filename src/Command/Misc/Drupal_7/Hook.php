<?php

namespace DrupalCodeGenerator\Command\Misc\Drupal_7;

use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\Command\ModuleGenerator;
use Symfony\Component\Console\Question\Question;

/**
 * Implements misc:d7:hook command.
 */
final class Hook extends ModuleGenerator {

  protected $name = 'misc:d7:hook';
  protected $description = 'Generates a hook';

  /**
   * {@inheritdoc}
   */
  protected function generate() :void {
    $vars = &$this->collectDefault();

    $question = new Question('Hook name');
    $question->setValidator(function (?string $value) :?string {
      if (!in_array($value, $this->getSupportedHooks())) {
        throw new \UnexpectedValueException('The value is not correct hook name.');
      }
      return $value;
    });
    $question->setAutocompleterValues($this->getSupportedHooks());

    $vars['hook_name'] = $this->io->askQuestion($question);

    // Most Drupal hooks are situated in a module file but some are not.
    $special_hooks = [
      'install' => [
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
      ],
      // See system_hook_info().
      'tokens.inc' => [
        'token_info',
        'token_info_alter',
        'tokens',
        'tokens_alter',
      ],
    ];

    $file_type = 'module';
    foreach ($special_hooks as $group => $hooks) {
      if (in_array($vars['hook_name'], $hooks)) {
        $file_type = $group;
        break;
      }
    }

    $this->addFile("{machine_name}.$file_type")
      ->headerTemplate("misc/d7/file-docs/$file_type")
      ->template('misc/d7/hook/{hook_name}')
      ->action(Asset::APPEND)
      ->headerSize(7);
  }

  /**
   * Gets list of supported hooks.
   *
   * @return array
   *   List of supported hooks.
   */
  protected function getSupportedHooks() :array {
    return array_map(function (string $file) :string {
      return pathinfo($file, PATHINFO_FILENAME);
    }, array_diff(scandir($this->templatePath . '/misc/d7/hook'), ['.', '..']));
  }

}
