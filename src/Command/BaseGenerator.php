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
  protected function configure():void {
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
        'answer',
        '-a',
        InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
        'Answer to generator question'
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
  protected function initialize(InputInterface $input, OutputInterface $output) :void {
    $this->getHelperSet()->setCommand($this);
    $this->getHelper('renderer')->addPath($this->templatePath);

    $directory = $input->getOption('directory') ?: getcwd();
    // No need to look up for extension root when generating an extension.
    $extension_destinations = ['modules', 'profiles', 'themes'];
    $is_extension = in_array($this->destination, $extension_destinations);
    $this->directory = $is_extension
      ? $directory : (Utils::getExtensionRoot($directory) ?: $directory);

    $header = sprintf("\n Welcome to %s generator!", $this->getName());
    $output->writeln($header);
    $header_length = strlen(trim(strip_tags($header)));
    $output->writeln('<fg=cyan;options=bold>–' . str_repeat('–', $header_length) . '–</>');
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) :int {

    // Render all assets.
    $renderer = $this->getHelper('renderer');
    foreach ($this->getAssets() as $asset) {
      // Supply the asset with all collected variables if it has no local ones.
      if (!$asset->getVars()) {
        $asset->vars($this->vars);
      }
      $renderer->renderAsset($asset);
    }

    $dumped_assets = $this->getHelper('dumper')
      ->dump($input, $output, $this->getAssets(), $this->getDirectory());

    $this->getHelper('output_handler')
      ->printSummary($output, $dumped_assets, $this->getDirectory());

    return 0;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() :?string {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function getAssets() :array {
    return $this->assets;
  }

  /**
   * {@inheritdoc}
   */
  public function setDirectory(string $directory) :void {
    $this->directory = $directory;
  }

  /**
   * {@inheritdoc}
   */
  public function getDirectory() :string {
    return $this->directory;
  }

  /**
   * {@inheritdoc}
   */
  public function setDestination(string $destination) {
    $this->destination = $destination;
  }

  /**
   * {@inheritdoc}
   */
  public function getDestination() :string {
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
  protected function render(string $template, array $vars) :string {
    return $this->getHelper('renderer')->render($template, $vars);
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
  protected function &collectVars(InputInterface $input, OutputInterface $output, array $questions, array $vars = []) : array {
    $this->vars += $this->getHelper('input_handler')->collectVars($input, $output, $questions, $vars);
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
   * @return string|null
   *   The answer.
   *
   * @see \DrupalCodeGenerator\InputHandler::collectVars()
   */
  protected function ask(InputInterface $input, OutputInterface $output, Question $question, array $vars = []) :?string {
    $key = mt_rand();
    $answers = $this->getHelper('input_handler')->collectVars($input, $output, [$key => $question], $vars);
    return $answers[$key];
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
  protected function addAsset(string $type) :Asset {
    $asset = (new Asset())->type($type);
    $this->assets[] = $asset;
    return $asset;
  }

  /**
   * Creates file asset.
   *
   * @param string $path
   *   (Optional) File path.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addFile($path = NULL) {
    return $this->addAsset('file')->path($path);
  }

  /**
   * Creates directory asset.
   *
   * @param string $path
   *   (Optional) Directory path.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addDirectory(string $path = NULL) :Asset {
    return $this->addAsset('directory')->path($path);
  }

  /**
   * Creates service file asset.
   *
   * @param string $path
   *   (Optional) File path.
   *
   * @return \DrupalCodeGenerator\Asset
   *   The asset.
   */
  protected function addServicesFile(string $path = NULL) :Asset {
    return $this->addFile()
      ->path($path ?: '{machine_name}.services.yml')
      ->action('append')
      ->headerSize(1);
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
  protected function collectServices(InputInterface $input, OutputInterface $output) :array {

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
  protected static function getServiceDefinitions() :array {
    $data_encoded = file_get_contents(ApplicationFactory::getRoot() . '/resources/service-definitions.json');
    return json_decode($data_encoded, TRUE);
  }

}
