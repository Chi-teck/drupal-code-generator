<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Commands\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
    $questions['hook_name'] = [
      'Hook name',
      NULL,
      function ($value) {
        if (!in_array($value, self::supportedHooks())) {
          return 'This hook is not supported.';
        }
      },
      self::supportedHooks(),
    ];

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

    $this->hooks[$vars['machine_name'] . '.' . $file_type][] = [
      'file_doc' => $this->render("d7/file-docs/$file_type.twig", $vars),
      'code' => $this->render('d7/hook/' . $vars['hook_name'] . '.twig', $vars),
    ];
  }

  /**
   * Returns list of supported hooks.
   */
  protected static function supportedHooks() {
    return array_map(function ($file) {
      return pathinfo($file, PATHINFO_FILENAME);
    }, array_diff(scandir(DCG_ROOT . '/src/Templates/d7/hook'), ['.', '..']));
  }

}
