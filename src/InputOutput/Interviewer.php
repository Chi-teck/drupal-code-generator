<?php

declare(strict_types=1);

namespace DrupalCodeGenerator\InputOutput;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Attribute\Generator as GeneratorDefinition;
use DrupalCodeGenerator\Helper\Drupal\ExtensionInfoInterface;
use DrupalCodeGenerator\Helper\Drupal\PermissionInfo;
use DrupalCodeGenerator\Helper\Drupal\ServiceInfo;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Validator\Chained;
use DrupalCodeGenerator\Validator\MachineName;
use DrupalCodeGenerator\Validator\Optional;
use DrupalCodeGenerator\Validator\Required;
use DrupalCodeGenerator\Validator\RequiredClassName;
use DrupalCodeGenerator\Validator\RequiredMachineName;
use DrupalCodeGenerator\Validator\ServiceExists;
use DrupalCodeGenerator\Validator\ServiceName;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Defines a helper to interact with a user.
 */
final class Interviewer {

  /**
   * Constructs the object.
   *
   * @noinspection PhpPropertyCanBeReadonlyInspection
   */
  public function __construct(
    private readonly IO $io,
    // With readonly attribute it fails on CI by some reason.
    private array &$vars,
    private readonly GeneratorDefinition $generatorDefinition,
    private readonly ServiceInfo $serviceInfo,
    private readonly ExtensionInfoInterface $extensionInfo,
    private readonly PermissionInfo $permissionInfo,
  ) {}

  /**
   * Asks a question.
   *
   * @psalm-param callable(mixed $value): mixed $validator
   */
  public function ask(string $question, ?string $default = NULL, ?callable $validator = NULL): mixed {
    $question = $this->processText($question);
    if ($default !== NULL) {
      $default = $this->processText($default);
    }
    return $this->io->ask($question, $default, $validator);
  }

  /**
   * Asks for confirmation.
   */
  public function confirm(string $question, bool $default = TRUE): bool {
    $question = $this->processText($question);
    return $this->io->confirm($question, $default);
  }

  /**
   * Asks a choice question.
   *
   * @psalm-param array<array-key, string> $choices
   */
  public function choice(string $question, array $choices, ?string $default = NULL, bool $multiselect = FALSE): array|string|int {
    $question = $this->processText($question);

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

    /** @psalm-suppress FalsableReturnStatement, InvalidFalsableReturnType */
    $get_key = static fn (string $answer): string|int => \array_search($answer, $choices);
    return \is_array($answer) ? \array_map($get_key, $answer) : $get_key($answer);
  }

  /**
   * Asks name question.
   */
  public function askName(): string {

    $machine_name = $this->vars['machine_name'] ?? NULL;
    $type = $this->generatorDefinition->type;

    // Try to determine the name without interaction with the user.
    if ($machine_name && !$type->isNewExtension()) {
      $name = $this->extensionInfo->getExtensionName($machine_name);
      if ($name) {
        return $name;
      }
    }

    $default = $machine_name ? Utils::machine2human($machine_name) : NULL;
    $question = new Question($type->getNameLabel(), $default);
    $question->setValidator(new Required());
    return $this->io->askQuestion($question);
  }

  /**
   * Asks machine name question.
   */
  public function askMachineName(): string {
    $type = $this->generatorDefinition->type;

    if (isset($this->vars['name'])) {
      $default = $type->isNewExtension() ?
        Utils::human2machine($this->vars['name']) : $this->extensionInfo->getExtensionMachineName($this->vars['name']);
    }
    $default ??= $this->extensionInfo->getExtensionFromPath($this->io->getWorkingDirectory())?->getName();

    $question = new Question($type->getMachineNameLabel(), $default);
    $question->setValidator(new Chained(new Required(), new MachineName()));

    if ($extensions = $this->extensionInfo->getExtensions()) {
      $question->setAutocompleterValues(\array_keys($extensions));
    }

    return $this->io->askQuestion($question);
  }

  /**
   * Asks class question.
   */
  public function askClass(string $question = 'Class', ?string $default = NULL): string {
    return $this->ask($question, $default, new RequiredClassName());
  }

  /**
   * Asks plugin label question.
   */
  public function askPluginLabel(string $question = 'Plugin label', ?string $default = NULL): string {
    return $this->ask($question, $default, new Required());
  }

  /**
   * Asks plugin ID question.
   */
  public function askPluginId(string $question = 'Plugin ID', ?string $default = '{machine_name}_{plugin_label|h2m}'): string {
    return $this->ask($question, $default, new RequiredMachineName());
  }

  /**
   * Asks plugin class question.
   */
  public function askPluginClass(string $question = 'Plugin class', ?string $default = NULL, string $suffix = ''): ?string {
    if ($default === NULL && isset($this->vars['machine_name'], $this->vars['plugin_id'])) {
      $unprefixed_plugin_id = Utils::removePrefix($this->vars['plugin_id'], $this->vars['machine_name'] . '_');
      $default = Utils::camelize($unprefixed_plugin_id) . $suffix;
    }
    return $this->askClass($question, $default);
  }

  /**
   * Collects services.
   *
   * @psalm-param list<string> $forced_services
   *
   * @psalm-return array<string, array{name: string, type?: string, description: string, short_type: string}>
   */
  public function askServices(bool $default = TRUE, array $forced_services = []): array {
    $services = $forced_services;

    if ($this->io->confirm('Would you like to inject dependencies?', $default)) {
      $service_ids = $this->serviceInfo->getServicesIds();
      $validator = new Chained(
        new Optional(new ServiceName()),
        new Optional(new ServiceExists($this->serviceInfo)),
      );
      while (TRUE) {
        $question = new Question('Type the service name or use arrows up/down. Press enter to continue');
        $question->setValidator($validator);
        $question->setAutocompleterValues($service_ids);
        $service = $this->io->askQuestion($question);
        if (!$service) {
          break;
        }
        $services[] = $service;
      }
    }

    $definitions = [];
    foreach (\array_unique($services) as $service_id) {
      $definitions[$service_id] = $this->serviceInfo->getServiceMeta($service_id);
    }
    return $definitions;
  }

  /**
   * Asks permission.
   */
  public function askPermission(string $question = 'Permission', ?string $default = NULL): string {
    $question = new Question($question, $default);
    $question->setValidator(new Required());
    $permissions = $this->permissionInfo->getPermissionNames();
    if (\count($permissions) > 0) {
      $question->setAutocompleterValues($permissions);
    }
    return $this->io->askQuestion($question);
  }

  /**
   * Gets service definition.
   *
   * @psalm-return array{name: string, type?: string, description: string, short_type: string}
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

  /**
   * Processes the text using previously collected variables.
   */
  private function processText(string $question): string {
    return Utils::stripSlashes(Utils::replaceTokens($question, $this->vars));
  }

}
