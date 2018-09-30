<?php

namespace DrupalCodeGenerator\Command;

use DrupalCodeGenerator\ApplicationFactory;
use DrupalCodeGenerator\Asset;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Base class for all generators.
 */
abstract class BaseGenerator extends Command implements GeneratorInterface {

  /**
   * The command name.
   *
   * @var string
   */
  protected $name;

  /**
   * The command description.
   *
   * @var string
   */
  protected $description;

  /**
   * The command alias.
   *
   * @var string
   */
  protected $alias;

  /**
   * Command label.
   *
   * @var string
   */
  protected $label;

  /**
   * A path where templates are stored.
   *
   * @var string
   */
  protected $templatePath;

  /**
   * The working directory.
   *
   * @var string
   */
  protected $directory;

  /**
   * The destination.
   *
   * @var mixed
   */
  protected $destination = 'modules/%';

  /**
   * Files to create.
   *
   * The key of the each item in the array is the path to the file and
   * the value is the generated content of it.
   *
   * @var array
   *
   * @deprecated Use self::$assets.
   */
  protected $files = [];

  /**
   * Assets to create.
   *
   * @var \DrupalCodeGenerator\Asset[]
   */
  protected $assets = [];

  /**
   * Twig template variables.
   *
   * @var array
   */
  protected $vars = [];

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName($this->name)
      ->setDescription($this->description)
      ->addOption(
        'directory',
        '-d',
        InputOption::VALUE_OPTIONAL,
        'Working directory'
      )
      ->addOption(
        'answers',
        '-a',
        InputOption::VALUE_OPTIONAL,
        'Default JSON formatted answers'
      );

    if ($this->alias) {
      $this->setAliases([$this->alias]);
    }

    if (!$this->templatePath) {
      $this->templatePath = ApplicationFactory::getRoot() . '/templates';
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output) {
    $this->getHelperSet()->setCommand($this);
    $this->getHelper('dcg_renderer')->addPath($this->templatePath);

    $directory = $input->getOption('directory') ?: getcwd();
    // No need to look up for extension root when generating an extension.
    $extension_destinations = ['modules', 'profiles', 'themes'];
    $is_extension = in_array($this->destination, $extension_destinations);
    $this->directory = $is_extension
      ? $directory : (Utils::getExtensionRoot($directory) ?: $directory);

    // Display welcome message.
    $header = sprintf(
      "\n Welcome to %s generator!",
      $this->getName()
    );
    $output->writeln($header);
    $header_length = strlen(trim(strip_tags($header)));
    $output->writeln('<fg=cyan;options=bold>–' . str_repeat('–', $header_length) . '–</>');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {

    // Render all assets.
    $renderer = $this->getHelper('dcg_renderer');
    foreach ($this->getAssets() as $asset) {
      // Supply the asset with all collected variables if it has no local ones.
      if (!$asset->getVars()) {
        $asset->vars($this->vars);
      }
      $asset->render($renderer);
    }

    $dumped_files = $this->getHelper('dcg_dumper')->dump($input, $output);
    $this->getHelper('dcg_output_handler')->printSummary($output, $dumped_files);
    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * Returns list of rendered files.
   *
   * @return array
   *   An associative array where each key is path to a file and value is
   *   rendered content.
   *
   * @deprecated.
   */
  public function getFiles() {
    return $this->files;
  }

  /**
   * {@inheritdoc}
   */
  public function getAssets() {
    if ($this->files) {
      // Convert files into assets for legacy commands.
      $assets = [];
      foreach ($this->getFiles() as $path => $file) {
        $asset = new Asset();
        $asset->path($path);
        if (!is_array($file)) {
          $file = ['content' => $file];
        }
        if (isset($file['content'])) {
          $asset->content($file['content']);
        }
        else {
          $asset->type('directory');
        }
        if (isset($file['action'])) {
          $asset->action($file['action']);
        }
        if (isset($file['header_size'])) {
          $asset->headerSize($file['header_size']);
        }
        if (isset($file['mode'])) {
          $asset->mode($file['mode']);
        }
        $assets[] = $asset;
      }
      return array_merge($assets, $this->assets);
    }

    return $this->assets;
  }

  /**
   * {@inheritdoc}
   */
  public function setDirectory($directory) {
    $this->directory = $directory;
  }

  /**
   * {@inheritdoc}
   */
  public function getDirectory() {
    return $this->directory;
  }

  /**
   * {@inheritdoc}
   */
  public function setDestination($destination) {
    $this->destination = $destination;
  }

  /**
   * {@inheritdoc}
   */
  public function getDestination() {
    return $this->destination;
  }

  /**
   * Renders a template.
   *
   * @param string $template
   *   Twig template.
   * @param array $vars
   *   Template variables.
   *
   * @return string
   *   A string representing the rendered output.
   */
  protected function render($template, array $vars) {
    return $this->getHelper('dcg_renderer')->render($template, $vars);
  }

  /**
   * Asks the user for template variables.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param array $questions
   *   List of questions that the user should answer.
   * @param array $vars
   *   Array of predefined template variables.
   *
   * @return array
   *   Template variables.
   *
   * @see \DrupalCodeGenerator\InputHandler::collectVars()
   */
  protected function &collectVars(InputInterface $input, OutputInterface $output, array $questions, array $vars = []) {
    $this->vars += $this->getHelper('dcg_input_handler')->collectVars($input, $output, $questions, $vars);
    return $this->vars;
  }

  /**
   * Asks the user a single question and returns the answer.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   * @param \Symfony\Component\Console\Question\Question $question
   *   A question to ask.
   * @param array $vars
   *   Array of predefined template variables.
   *
   * @return string
   *   The answer.
   *
   * @see \DrupalCodeGenerator\InputHandler::collectVars()
   */
  protected function ask(InputInterface $input, OutputInterface $output, Question $question, array $vars = []) {
    $answers = $this->getHelper('dcg_input_handler')->collectVars($input, $output, ['key' => $question], $vars);
    return $answers['key'];
  }

  /**
   * Creates an asset.
   *
   * @param string $type
   *   Asset type.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addAsset($type) {
    $asset = (new Asset())->type($type);
    $this->assets[] = $asset;
    return $asset;
  }

  /**
   * Creates file asset.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addFile() {
    return $this->addAsset('file');
  }

  /**
   * Creates directory asset.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addDirectory() {
    return $this->addAsset('directory');
  }

  /**
   * Creates service file asset.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addServicesFile() {
    return $this->addFile()
      ->path('{machine_name}.services.yml')
      ->action('append')
      ->headerSize(1);
  }

  /**
   * Creates file asset.
   *
   * @param string $path
   *   Path to the file.
   * @param string $template
   *   Twig template to render.
   * @param array $vars
   *   Twig variables.
   *
   * @deprecated Use self::addFile() or self::addDirectory().
   */
  protected function setFile($path = NULL, $template = NULL, array $vars = []) {
    $this->addFile()
      ->path($path)
      ->template($template)
      ->vars($vars);
  }

  /**
   * Creates service file asset.
   *
   * @param string $path
   *   Path to the file.
   * @param string $template
   *   Twig template to render.
   * @param array $vars
   *   Twig variables.
   *
   * @deprecated Use self::addServiceFile().
   */
  protected function setServicesFile($path, $template, array $vars) {
    $this->addServicesFile()
      ->path($path)
      ->template($template)
      ->vars($vars);
  }

  /**
   * Collects services.
   *
   * @param \Symfony\Component\Console\Input\InputInterface $input
   *   Input instance.
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *   Output instance.
   *
   * @return array
   *   List of collected services.
   */
  protected function collectServices(InputInterface $input, OutputInterface $output) {

    $service_definitions = self::getServiceDefinitions();
    $service_ids = array_keys($service_definitions);

    $services = [];
    while (TRUE) {
      $question = new Question('Type the service name or use arrows up/down. Press enter to continue');
      $question->setValidator([Utils::class, 'validateServiceName']);
      $question->setAutocompleterValues($service_ids);
      $service = $this->ask($input, $output, $question);
      if (!$service) {
        break;
      }
      $services[] = $service;
    }

    $this->vars['services'] = [];
    foreach (array_unique($services) as $service_id) {
      if (isset($service_definitions[$service_id])) {
        $definition = $service_definitions[$service_id];
      }
      else {
        // Build the definition if the service is unknown.
        $definition = [
          'type' => 'Drupal\example\ExampleInterface',
          'name' => str_replace('.', '_', $service_id),
          'description' => "The $service_id service.",
        ];
      }
      $type_parts = explode('\\', $definition['type']);
      $definition['short_type'] = end($type_parts);
      $this->vars['services'][$service_id] = $definition;
    }
    return $this->vars['services'];
  }

  /**
   * Gets service definitions.
   *
   * @return array
   *   List of service definitions keyed by service ID.
   */
  protected static function getServiceDefinitions() {
    $data_encoded = file_get_contents(ApplicationFactory::getRoot() . '/resources/service-definitions.json');
    return json_decode($data_encoded, TRUE);
  }

}
