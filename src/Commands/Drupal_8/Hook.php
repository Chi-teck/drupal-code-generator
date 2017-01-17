<?php

namespace DrupalCodeGenerator\Commands\Drupal_8;

use DrupalCodeGenerator\Commands\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Implements d8:hook command.
 */
class Hook extends BaseGenerator {

  protected $name = 'd8:hook';
  protected $description = 'Generates a hook';
  protected $alias = 'hook';

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
      'schema',
      'requirements',
      'update_N',
      'update_last_removed',
    ];

    $file_type = in_array($vars['hook_name'], $install_hooks) ? 'install' : 'module';

    $this->hooks[$vars['machine_name'] . '.' . $file_type] = [
      'file_doc' => $this->render("d8/file-docs/$file_type.twig", $vars),
      'code' => $this->render('d8/hook/' . $vars['hook_name'] . '.twig', $vars),
    ];
  }

  /**
   * Returns list of supported hooks.
   */
  protected static function supportedHooks() {
    return array_map(function ($file) {
      return pathinfo($file, PATHINFO_FILENAME);
    }, array_diff(scandir(DCG_ROOT . '/src/Templates/d8/hook'), ['.', '..']));
  }

}
