<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:module:standard command.
 */
class Standard extends ModuleGenerator {

  protected $name = 'd8:module:standard';
  protected $description = 'Generates standard Drupal 8 module';
  protected $alias = 'module';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) :void {
    $this->collectDefault();

    $questions['description'] = new Question('Module description', 'The description.');
    $questions['package'] = new Question('Package', 'Custom');
    $questions['dependencies'] = new Question('Dependencies (comma separated)');

    $vars = &$this->collectVars($questions);

    if ($vars['dependencies']) {
      $vars['dependencies'] = array_map('trim', explode(',', strtolower($vars['dependencies'])));
    }

    $prefix = $vars['machine_name'] . '/' . $vars['machine_name'];

    $this->addFile()
      ->path($prefix . '.info.yml')
      ->template('d8/yml/module-info.twig');

    $this->addFile()
      ->path($prefix . '.module')
      ->template('d8/module.twig');

    $class_prefix = Utils::camelize($vars['name']);

    // Additional files.
    $options['install_file'] = $this->confirm('Would you like to create install file?', TRUE);
    $options['libraries.yml'] = $this->confirm('Would you like to create libraries.yml file?', TRUE);
    $options['permissions.yml'] = $this->confirm('Would you like to create permissions.yml file?', TRUE);
    $options['event_subscriber'] = $this->confirm('Would you like to create event subscriber?', TRUE);
    $options['block_plugin'] = $this->confirm('Would you like to create block plugin?', TRUE);
    $options['controller'] = $this->confirm('Would you like to create a controller?', TRUE);
    $options['settings_form'] = $this->confirm('Would you like to create settings form?', TRUE);

    if ($options['install_file']) {
      $this->addFile($prefix . '.install')
        ->template('d8/install.twig');
    }

    if ($options['libraries.yml']) {
      $this->addFile($prefix . '.libraries.yml')
        ->template('d8/yml/module-libraries.twig');
    }

    if ($options['permissions.yml']) {
      $this->addFile($prefix . '.permissions.yml')
        ->template('d8/yml/permissions.twig');
    }

    if ($options['event_subscriber']) {
      $subscriber_class = $class_prefix . 'Subscriber';

      $this->addFile("{machine_name}/src/EventSubscriber/$subscriber_class.php")
        ->template('d8/service/event-subscriber.twig')
        ->vars($vars + ['class' => $subscriber_class]);

      $this->addFile($prefix . '.services.yml')
        ->template('d8/service/event-subscriber.services.twig')
        ->vars($vars + ['class' => $subscriber_class]);
    }

    if ($options['block_plugin']) {
      $block_vars['plugin_label'] = 'Example';
      $block_vars['plugin_id'] = $vars['machine_name'] . '_' . Utils::human2machine($block_vars['plugin_label']);
      $block_vars['category'] = $vars['name'];
      $block_vars['class'] = 'ExampleBlock';

      $this->addFile('{machine_name}/src/Plugin/Block/' . $block_vars['class'] . '.php')
        ->template('d8/plugin/block.twig')
        ->vars($block_vars + $vars);
    }

    if ($options['controller']) {
      $controller_class = $class_prefix . 'Controller';

      $controller_vars = [
        'class' => $controller_class,
        'services' => [],
      ];

      $this->addFile("{machine_name}/src/Controller/$controller_class.php")
        ->template('d8/controller.twig')
        ->vars($controller_vars + $vars);

      $routing_vars = [
        'route_name' => $vars['machine_name'] . '.example',
        'route_path' => '/' . str_replace('_', '-', $vars['machine_name']) . '/example',
        'route_title' => 'Example',
        'route_permission' => 'access content',
        'class' => $controller_class,
      ];

      $this->addFile($prefix . '.routing.yml')
        ->template('d8/controller-route.twig')
        ->vars($routing_vars + $vars)
        ->action('append');
    }

    if ($options['settings_form']) {
      $form_class = 'SettingsForm';

      $form_vars = [
        'form_id' => $vars['machine_name'] . '_settings',
        'class' => $form_class,
      ];
      $this->addFile('{machine_name}/src/Form/SettingsForm.php')
        ->template('d8/form/config.twig')
        ->vars($form_vars + $vars);

      $routing_vars = [
        'route_name' => $vars['machine_name'] . '.settings_form',
        'route_path' => '/admin/config/system/' . str_replace('_', '-', $vars['machine_name']),
        'route_title' => $vars['name'] . ' settings',
        'route_permission' => 'administer ' . $vars['machine_name'] . ' configuration',
        'class' => $form_class,
      ];
      $this->addFile($prefix . '.routing.yml')
        ->template('d8/form/routing.twig')
        ->vars($routing_vars + $vars)
        ->action('append');
    }

  }

}
