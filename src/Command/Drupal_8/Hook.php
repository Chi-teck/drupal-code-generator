<?php

namespace DrupalCodeGenerator\Command\Drupal_8;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

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
    $questions['hook_name'] = new Question('Hook name');
    $questions['hook_name']->setValidator(function ($value) {
      if (!in_array($value, $this->supportedHooks())) {
        throw new \UnexpectedValueException('The value is not correct class name.');
      }
      return $value;
    });
    $questions['hook_name']->setAutocompleterValues($this->supportedHooks());

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

    $header = $this->render("d8/file-docs/$file_type.twig", $vars);
    $content = $this->render('d8/hook/' . $vars['hook_name'] . '.twig', $vars);

    $this->files[$vars['machine_name'] . '.' . $file_type] = [
      'content' => $header . "\n" . $content,
      'action' => 'append',
      'header_size' => 7,
    ];
  }

  /**
   * Returns list of supported hooks.
   */
  protected function supportedHooks() {
    return array_map(function ($file) {
      return pathinfo($file, PATHINFO_FILENAME);
    }, array_diff(scandir($this->templatePath . '/d8/hook'), ['.', '..']));
  }

}
