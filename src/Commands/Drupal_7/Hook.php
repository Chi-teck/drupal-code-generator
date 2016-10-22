<?php

namespace DrupalCodeGenerator\Commands\Drupal_7;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

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

    $questions = [
      'name' => ['Module name'],
      'machine_name' => ['Module machine name'],
      'hook_name' => [
        'Hook name',
        NULL,
        [$this, 'validateHookName'],
        $this->getSupportedHooks(),
      ],
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

    if (in_array($vars['hook_name'], $install_hooks)) {
      $file_type = 'install';
    }
    else {
      $file_type = 'module';
    }

    $this->hooks[$vars['machine_name'] . '.' . $file_type] = [
      'file_doc' => $this->render("d7/file-docs/$file_type.twig", $vars),
      'code' => $this->render('d7/hook/' . $vars['hook_name'] . '.twig', $vars),
    ];

  }

  /**
   * Hook name validator.
   */
  protected function validateHookName($value) {
    if (!in_array($value, $this->getSupportedHooks())) {
      return 'This hook is not supported.';
    }
  }

  /**
   * Returns list of supported hooks.
   */
  protected function getSupportedHooks() {
    return array_map(function ($file) {
      return pathinfo($file, PATHINFO_FILENAME);
    }, array_diff(scandir(DCG_ROOT . '/src/Templates/d7/hook'), ['.', '..']));
  }

}
