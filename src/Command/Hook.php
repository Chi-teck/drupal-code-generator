<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\Choice;
use DrupalCodeGenerator\Validator\Required;
use Symfony\Component\Console\Question\Question;

#[Generator(
  name: 'hook',
  description: 'Generates a hook',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Hook extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    /** @var \DrupalCodeGenerator\Helper\Drupal\HookInfo $hook_info */
    $hook_info = $this->getHelper('hook_info');

    $hook_templates = $hook_info->getHookTemplates();
    $available_hooks = \array_keys($hook_templates);

    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $hook_question = new Question('Hook name');
    $validator = new Chained(
      new Required(),
      new Choice($available_hooks, 'The value is not correct hook name.'),
    );
    $hook_question->setValidator($validator);
    $hook_question->setAutocompleterValues($available_hooks);
    $vars['hook_name'] = $this->io()->askQuestion($hook_question);

    $vars['file_type'] = $hook_info::getFileType($vars['hook_name']);

    $assets->addFile('{machine_name}.{file_type}')
      ->inlineTemplate($hook_templates[$vars['hook_name']])
      ->appendIfExists(9);
  }

}
