<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\Required;
use Symfony\Component\Console\Question\Question;

#[Generator(
  name: 'hook',
  description: 'Generates a hook',
  type: GeneratorType::MODULE_COMPONENT,
)]
final class Hook extends BaseGenerator {

  protected function generate(array &$vars, AssetCollection $assets): void {
    $hook_info = $this->getHelper('hook_info');
    $available_hooks = $hook_info->getHookTemplates();

    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();

    $hook_question = new Question('Hook name');
    $hook_question->setValidator(self::getHookValidator($available_hooks));
    $hook_question->setAutocompleterValues($available_hooks);
    $vars['hook_name'] = $this->io()->askQuestion($hook_question);

    $vars['file_type'] = $hook_info->getFileType($vars['hook_name']);

    $file = $assets->addFile('{machine_name}.{file_type}')
      ->appendIfExists(7);

    $hook_template = $available_hooks[$vars['hook_name']];
    $file->inlineTemplate($hook_template);
  }

  private static function getHookValidator(array $available_hooks): callable {
    return new Chained(
      new Required(),
      static function (string $value) use ($available_hooks): string {
        if (!\array_key_exists($value, $available_hooks)) {
          throw new \UnexpectedValueException('The value is not correct hook name.');
        }
        return $value;
      },
    );
  }

}
