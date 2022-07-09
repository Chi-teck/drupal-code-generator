<?php declare(strict_types=1);

namespace DrupalCodeGenerator\InputOutput;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Attribute\Generator as GeneratorDefinition;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\Helper\Drupal\ModuleInfo;
use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;
use DrupalCodeGenerator\Helper\Drupal\ThemeInfo;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\MachineName;
use DrupalCodeGenerator\Validator\Optional;
use DrupalCodeGenerator\Validator\Required;
use DrupalCodeGenerator\Validator\RequiredClassName;
use DrupalCodeGenerator\Validator\RequiredMachineName;
use DrupalCodeGenerator\Validator\ServiceName;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Defines a helper to interact with a user.
 *
 * @todo Create a test for this.
 */
final class Interviewer {

  public function __construct(
    private readonly IO $io,
    private readonly array &$vars,
    private readonly GeneratorDefinition $generatorDefinition,
    private readonly ModuleInfo $moduleInfo,
    private readonly ThemeInfo $themeInfo,
    private readonly ServiceInfo $serviceInfo,
  ) {}

  public function askQuestion(Question $question): mixed {
    $answer = $this->io->askQuestion($question);
    if (\is_string($answer)) {
      $answer = Utils::addSlashes($answer);
    }
    return $answer;
  }

  /**
   * Asks a question.
   */
  public function ask(string $question, ?string $default = NULL, ?callable $validator = NULL): mixed {
    $question = Utils::stripSlashes(Utils::replaceTokens($question, $this->vars));
    if ($default !== NULL) {
      $default = Utils::stripSlashes(Utils::replaceTokens($default, $this->vars));
    }
    return $this->io->ask($question, $default, $validator);
  }

  /**
   * Asks for confirmation.
   */
  public function confirm(string $question, bool $default = TRUE): bool {
    $question = Utils::stripSlashes(Utils::replaceTokens($question, $this->vars));
    return $this->io->confirm($question, $default);
  }

  /**
   * Asks a choice question.
   */
  public function choice(string $question, array $choices, ?string $default = NULL, bool $multiselect = FALSE): array|string|int {
    $question = Utils::stripSlashes(Utils::replaceTokens($question, $this->vars));

    // The choices can be an associative array.
    $choice_labels = \array_values($choices);
    // Start choices list form '1'.
    \array_unshift($choice_labels, NULL);
    unset($choice_labels[0]);

    $question = new ChoiceQuestion($question, $choice_labels, $default);
    $question->setMultiselect($multiselect);

    // Do not use IO choice here as it prints choice key as default value.
    // @see \Symfony\Component\Console\Style\SymfonyStyle::choice().
    $answer = $this->io->askQuestion($question);

    // @todo Create a test for this.
    $get_key = static fn (string $answer): string|int => \array_search($answer, $choices);
    return \is_array($answer) ? \array_map($get_key, $answer) : $get_key($answer);
  }

  /**
   * Asks name question.
   */
  public function askName(): string {

    $type = $this->generatorDefinition->type;
    $machine_name = $this->vars['machine_name'] ?? NULL;

    // Try to determine the name without interaction with the user.
    if ($machine_name && !$type->isNewExtension()) {
      $name = match ($type) {
        GeneratorType::MODULE_COMPONENT => $this->moduleInfo->getModuleName($machine_name),
        GeneratorType::THEME_COMPONENT => $this->themeInfo->getThemeName($machine_name),
        default => NULL,
      };
      if ($name) {
        return $name;
      }
    }

    $question_str = match ($type) {
      GeneratorType::MODULE, GeneratorType::MODULE_COMPONENT => 'Module name',
      GeneratorType::THEME, GeneratorType::THEME_COMPONENT => 'Theme name',
      default => 'Name',
    };
    $default_value = $machine_name ? Utils::machine2human($machine_name) : NULL;
    $question = new Question($question_str, $default_value);
    $question->setValidator(new Required());
    return $this->io->askQuestion($question);
  }

  /**
   * Asks machine name question.
   */
  public function askMachineName(): string {

    $default_value = NULL;
    if (isset($this->vars['name'])) {
      if ($this->generatorDefinition->type->isNewExtension()) {
        $default_value = Utils::human2machine($this->vars['name']);
      }
      else {
        $default_value = match ($this->generatorDefinition->type) {
          GeneratorType::MODULE_COMPONENT => \array_search($this->vars['name'], $this->moduleInfo->getModules()),
          GeneratorType::THEME_COMPONENT => \array_search($this->vars['name'], $this->themeInfo->getThemes()),
          default => NULL,
        };
      }
    }
    $default_value ??= $this->moduleInfo->getModuleFromPath($this->io->getWorkingDirectory())?->getName();

    $question_str = match ($this->generatorDefinition->type) {
      GeneratorType::MODULE, GeneratorType::MODULE_COMPONENT => 'Module machine name',
      GeneratorType::THEME, GeneratorType::THEME_COMPONENT => 'Theme machine name',
      default => 'Machine name',
    };
    $question = new Question($question_str, $default_value);
    $question->setValidator(new Chained(new Required(), new MachineName()));

    $extensions = match ($this->generatorDefinition->type) {
      GeneratorType::MODULE_COMPONENT => $this->moduleInfo->getModules(),
      GeneratorType::THEME_COMPONENT => $this->themeInfo->getThemes(),
      default => [],
    };
    if ($extensions) {
      $question->setAutocompleterValues(\array_keys($extensions));
    }

    return $this->io->askQuestion($question);
  }

  /**
   * Asks class question.
   */
  public function askClass(string $question = 'Class', ?string $default_value = NULL): ?string {
    return $this->ask($question, $default_value, new RequiredClassName());
  }

  /**
   * Asks plugin label question.
   */
  public function askPluginLabel(string $question = 'Plugin label', ?string $default_value = NULL): ?string {
    return $this->ask($question, $default_value, new Required());
  }

  /**
   * Asks plugin ID question.
   */
  public function askPluginId(string $question = 'Plugin ID'): ?string {
    return $this->ask($question, '{machine_name}_{plugin_label|h2m}', new RequiredMachineName());
  }

  /**
   * Asks plugin class question.
   *
   * @todo Remove $suffix parameter.
   */
  public function askPluginClass(string $question = 'Plugin class', ?string $default_value = NULL, string $suffix = ''): ?string {
    if ($default_value === NULL && isset($this->vars['machine_name'], $this->vars['plugin_id'])) {
      $unprefixed_plugin_id = Utils::removePrefix($this->vars['plugin_id'], $this->vars['machine_name'] . '_');
      $default_value = Utils::camelize($unprefixed_plugin_id) . $suffix;
    }
    return $this->askClass($question, $default_value);
  }

  /**
   * Collects services.
   */
  public function askServices(bool $default = TRUE): array {

    if (!$this->io->confirm('Would you like to inject dependencies?', $default)) {
      return [];
    }

    $service_ids = $this->serviceInfo->getServicesIds();

    $services = [];
    while (TRUE) {
      $question = new Question('Type the service name or use arrows up/down. Press enter to continue');
      $question->setValidator(new Optional(new ServiceName()));
      $question->setAutocompleterValues($service_ids);
      $service = $this->io->askQuestion($question);
      if (!$service) {
        break;
      }
      $services[] = $service;
    }

    $definitions = [];
    foreach (\array_unique($services) as $service_id) {
      $definitions[$service_id] = $this->getServiceDefinition($service_id);
    }
    return $definitions;
  }

  /**
   * Gets service definition.
   */
  protected function getServiceDefinition(string $service_id): array {
    // @todo Fetch service information runtime.
    $service_definitions = self::getDumpedServiceDefinitions();
    if (isset($service_definitions[$service_id])) {
      $definition = $service_definitions[$service_id];
    }
    else {
      // Make up service definition.
      $name_parts = \explode('.', $service_id);
      $definition = [
        'name' => \end($name_parts),
        'type' => 'Drupal\example\ExampleInterface',
        'description' => "The $service_id service.",
      ];

      // Try to guess correct type of service instance.
      $compiled_definition = $this->serviceInfo->getServiceDefinition($service_id);
      if ($compiled_definition && isset($compiled_definition['class'])) {
        $interface = $compiled_definition['class'] . 'Interface';
        $definition['type'] = \interface_exists($interface) ? $interface : $compiled_definition['class'];
      }
    }

    $type_parts = \explode('\\', $definition['type']);
    $definition['short_type'] = \end($type_parts);

    return $definition;
  }

  /**
   * Gets service definitions.
   *
   * @return array
   *   List of service definitions keyed by service ID.
   */
  private static function getDumpedServiceDefinitions(): array {
    $data_encoded = \file_get_contents(Application::ROOT . '/resources/service-definitions.json');
    return \json_decode($data_encoded, TRUE);
  }

}
