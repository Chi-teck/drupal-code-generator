<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Implements d8:module:standard command.
 */
class Standard extends BaseGenerator {

  protected $name = 'd8:module:standard';
  protected $description = 'Generates standard Drupal 8 module';
  protected $alias = 'module';
  protected $destination = 'modules';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $questions = Utils::defaultQuestions();
    $questions['description'] = new Question('Module description', 'The description.');
    $questions['package'] = new Question('Package', 'Custom');
    $questions['dependencies'] = new Question('Dependencies (comma separated)');

    $vars = $this->collectVars($input, $output, $questions);

    if ($vars['dependencies']) {
      $vars['dependencies'] = array_map('trim', explode(',', strtolower($vars['dependencies'])));
    }

    $prefix = $vars['machine_name'] . '/' . $vars['machine_name'];
    $this->setFile($prefix . '.info.yml', 'd8/yml/module-info.twig', $vars);
    $this->setFile($prefix . '.module', 'd8/module.twig', $vars);

    $class_prefix = Utils::camelize($vars['name']);

    // Additional files.
    $option_questions['install_file'] = new ConfirmationQuestion('Would you like to create install file?', TRUE);
    $option_questions['libraries.yml'] = new ConfirmationQuestion('Would you like to create libraries.yml file?', TRUE);
    $option_questions['permissions.yml'] = new ConfirmationQuestion('Would you like to create permissions.yml file?', TRUE);
    $option_questions['event_subscriber'] = new ConfirmationQuestion('Would you like to create event subscriber?', TRUE);
    $option_questions['block_plugin'] = new ConfirmationQuestion('Would you like to create block plugin?', TRUE);
    $option_questions['controller'] = new ConfirmationQuestion('Would you like to create a controller?', TRUE);
    $option_questions['settings_form'] = new ConfirmationQuestion('Would you like to create settings form?', TRUE);

    $options = $this->collectVars($input, $output, $option_questions);

    if ($options['install_file']) {
      $this->setFile($prefix . '.install', 'd8/install.twig', $vars);
    }

    if ($options['libraries.yml']) {
      $this->setFile($prefix . '.libraries.yml', 'd8/yml/module-libraries.twig', $vars);
    }

    if ($options['permissions.yml']) {
      $this->setFile($prefix . '.permissions.yml', 'd8/yml/permissions.twig', $vars);
    }

    if ($options['event_subscriber']) {
      $subscriber_class = $class_prefix . 'Subscriber';
      $this->setFile(
        $vars['machine_name'] . '/src/EventSubscriber/' . $subscriber_class . '.php',
        'd8/service/event-subscriber.twig',
        $vars + ['class' => $subscriber_class]
      );
      $this->setServicesFile(
        $prefix . '.services.yml',
        'd8/service/event-subscriber.services.twig',
        $vars + ['class' => $subscriber_class]
      );
    }

    if ($options['block_plugin']) {
      $block_vars['plugin_label'] = 'Example';
      $block_vars['plugin_id'] = $vars['machine_name'] . '_' . Utils::human2machine($block_vars['plugin_label']);
      $block_vars['category'] = $vars['name'];
      $block_vars['class'] = 'ExampleBlock';
      $this->setFile(
        $vars['machine_name'] . '/src/Plugin/Block/' . $block_vars['class'] . '.php',
        'd8/plugin/block.twig',
        $vars + $block_vars
      );
    }

    if ($options['controller']) {
      $controller_class = $class_prefix . 'Controller';
      $this->setFile(
        $vars['machine_name'] . "/src/Controller/$controller_class.php",
        'd8/controller.twig',
        $vars + ['class' => $controller_class]
      );
      $routing_vars = [
        'route_name' => $vars['machine_name'] . '.example',
        'route_path' => '/' . str_replace('_', '-', $vars['machine_name']) . '/example',
        'route_title' => 'Example',
        'route_permission' => 'access content',
        'class' => $controller_class,
      ];
      $this->files[$prefix . '.routing.yml'] = [
        'content' => $this->render('d8/controller-route.twig', $vars + $routing_vars),
        'action' => 'append',
      ];
    }

    if ($options['settings_form']) {
      $form_class = 'SettingsForm';
      $form_vars = [
        'form_id' => $vars['machine_name'] . '_settings',
        'class' => $form_class,
      ];
      $this->setFile(
        $vars['machine_name'] . '/src/Form/SettingsForm.php',
        'd8/form/config.twig',
        $vars + $form_vars
      );
      $routing_vars = [
        'route_name' => $vars['machine_name'] . '.settings_form',
        'route_path' => '/admin/config/system/' . str_replace('_', '-', $vars['machine_name']),
        'route_title' => $vars['name'] . ' settings',
        'route_permission' => 'administer ' . $vars['machine_name'] . ' configuration',
        'class' => $form_class,
      ];

      $content = isset($this->files[$prefix . '.routing.yml']) ?
        $this->files[$prefix . '.routing.yml']['content'] . "\n" : '';
      $this->files[$prefix . '.routing.yml'] = [
        'content' => $content . $this->render('d8/form/route.twig', $vars + $routing_vars),
        'action' => 'append',
      ];
    }

  }

}
