<?php declare(strict_types = 1);

namespace DrupalCodeGenerator\Command;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Asset\LibraryDiscovery;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Extension\ExtensionLifecycle;
use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Asset\AssetCollection;
use DrupalCodeGenerator\Asset\File;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\GeneratorType;
use DrupalCodeGenerator\InputOutput\Interviewer;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Validator\Choice;
use DrupalCodeGenerator\Validator\Optional;
use DrupalCodeGenerator\Validator\Required;
use DrupalCodeGenerator\Validator\RequiredMachineName;
use Symfony\Component\Console\Question\Question;

#[Generator(
  name: 'single-directory-component',
  description: 'Generates Drupal SDC theme component',
  aliases: ['sdc'],
  templatePath: Application::TEMPLATE_PATH . '/_sdc',
  type: GeneratorType::THEME_COMPONENT,
)]
final class SingleDirectoryComponent extends BaseGenerator implements ContainerInjectionInterface {
  private const COMPONENT_PATH_TOKEN = '{directory}/{component_machine_name}/';

  /**
   * {@inheritdoc}
   */
  public function __construct(
    private readonly ModuleHandlerInterface $moduleHandler,
    private readonly ThemeHandlerInterface $themeHandler,
    private readonly LibraryDiscovery $libraryDiscovery,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('module_handler'),
      $container->get('theme_handler'),
      $container->get('library.discovery'),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, AssetCollection $assets): void {
    $this->askQuestions($vars);
    $this->generateAssets($vars, $assets);
  }

  private function askQuestions(array &$vars): array {
    $ir = $this->createInterviewer($vars);
    $vars['machine_name'] = $ir->askMachineName();
    $vars['name'] = $ir->askName();
    $vars['directory'] = $ir->ask('Components directory', 'components');

    $vars['component_name'] = $ir->ask('Component name', NULL, new Required());
    $vars['component_machine_name'] = $ir->ask(
      'Component machine name',
      Utils::human2machine($vars['component_name']),
      new RequiredMachineName(),
    );

    $vars['component_description'] = $ir->ask(
      'Component description (optional)',
    );
    $choices = [
      ExtensionLifecycle::STABLE,
      ExtensionLifecycle::EXPERIMENTAL,
      ExtensionLifecycle::DEPRECATED,
      ExtensionLifecycle::OBSOLETE,
    ];
    $vars['component_status'] = $ir->choice(
      'Project type',
      \array_combine($choices, $choices),
      ExtensionLifecycle::STABLE,
    );
    $vars['component_libraries'] = [];

    do {
      $library = $this->askLibrary();
      $vars['component_libraries'][] = $library;
    } while ($library !== NULL);

    $vars['component_libraries'] = \array_filter($vars['component_libraries']);
    $vars['component_has_css'] = $ir->confirm('Needs CSS?');
    $vars['component_has_js'] = $ir->confirm('Needs JS?');
    if ($ir->confirm('Needs component props?')) {
      $vars['component_props'] = [];
      do {
        $prop = $this->askProp($ir);
        $vars['component_props'][] = $prop;
      } while ($ir->confirm('Add another prop?'));
    }
    $vars['component_props'] = \array_filter(
      $vars['component_props'] ?? [],
    );
    return $vars;
  }

  /**
   * Create the assets that the framework will write to disk later on.
   *
   * @param array $vars
   *   The answers to the CLI questions.
   * @param \DrupalCodeGenerator\Asset\AssetCollection $assets
   *   List of all the files to generate.
   */
  private function generateAssets(array $vars, AssetCollection $assets): void {
    if (isset($vars['component_has_css']) && $vars['component_has_css'] !== FALSE) {
      $assets->addFile(
        self::COMPONENT_PATH_TOKEN . '{component_machine_name}.css',
        'main-css--template.twig',
      );
    }
    if (isset($vars['component_has_js']) && $vars['component_has_js'] !== FALSE) {
      $assets->addFile(
        self::COMPONENT_PATH_TOKEN . '{component_machine_name}.js',
        'main-js--template.twig',
      );
    }
    $assets->addFile(
      self::COMPONENT_PATH_TOKEN . '{component_machine_name}.twig',
      'component-twig--template.twig',
    );
    $assets->addFile(self::COMPONENT_PATH_TOKEN . '{component_machine_name}.component.yml', 'component-yml--template.twig');
    $assets->addFile(self::COMPONENT_PATH_TOKEN . 'README.md', 'readme-md--template.twig');

    $contents = \file_get_contents($this->getTemplatePath() . \DIRECTORY_SEPARATOR . 'thumbnail-placeholder.jpg');
    $thumbnail = new File(self::COMPONENT_PATH_TOKEN . 'thumbnail.jpg');
    $thumbnail->content($contents);
    $assets[] = $thumbnail;
  }

  /**
   * Prompts the user for a library.
   *
   * This helper gathers all the libraries from the system to allow autocomplete
   * and validation.
   *
   * @return string|null
   *   The library ID, if any.
   */
  private function askLibrary(): ?string {
    $extensions = [
      'core',
      ...\array_keys($this->moduleHandler->getModuleList()),
      ...\array_keys($this->themeHandler->listInfo()),
    ];
    $library_ids = \array_reduce(
      $extensions,
      fn (iterable $libs, $extension) => \array_merge(
        (array) $libs,
        \array_map(static fn (string $l) => \sprintf('%s/%s', $extension, $l),
          \array_keys($this->libraryDiscovery->getLibrariesByExtension($extension))),
      ),
      [],
    );

    $question = new Question("Library dependencies (optional). [Example: core/once]");
    $question->setAutocompleterValues($library_ids);
    $question->setValidator(
      new Optional(new Choice($library_ids, "Invalid library selected.")),
    );

    return $this->io()->askQuestion($question);
  }

  /**
   * Asks for multiple questions to define a prop and its schema.
   *
   * @return array
   *   The prop data, if any.
   */
  protected function askProp(Interviewer $ir): array {
    $prop = [];
    $prop['title'] = $ir->ask('Prop human name', NULL, new Required());
    $default = Utils::human2machine($prop['title']);
    $prop['name'] = $ir->ask('Prop machine name', $default, new RequiredMachineName());
    $prop['description'] = $ir->ask('Prop description (optional)');
    $prop['type'] = $ir->choice('Prop type', [
      'string' => 'String',
      'number' => 'Number',
      'boolean' => 'Boolean',
      'array' => 'Array',
      'object' => 'Object',
      'null' => 'Always null',
    ]);
    if (!\in_array($prop['type'], ['string', 'number', 'boolean'])) {
      $this->io()->warning('Unable to generate full schema for ' . $prop['type'] . '. Please edit metadata.json after generation.');
      return $prop;
    }
    $prop['examples'] = [];
    if ($prop['type'] === 'string') {
      // Gather examples.
      do {
        $example = $ir->ask('Give a prop example (optional)');
        $prop['examples'][] = $example;
      } while (!\is_null($example));
      $prop['examples'] = \array_filter($prop['examples']);
    }
    return $prop;
  }

}
