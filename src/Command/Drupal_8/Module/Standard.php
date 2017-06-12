<?php

namespace DrupalCodeGenerator\Command\Drupal_8\Module;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\Utils;

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
    $questions = Utils::defaultQuestions() + [
      'description' => ['Module description', 'The description.'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '8.x-1.0-dev'],
      'dependencies' => new Question('Dependencies (comma separated)', ''),
    ];

    $vars = $this->collectVars($input, $output, $questions);

    if ($vars['dependencies']) {
      $vars['dependencies'] = explode(',', $vars['dependencies']);
    }

    $prefix = $vars['machine_name'] . '/' . $vars['machine_name'];
    $this->files[$prefix . '.info.yml'] = $this->render('d8/yml/module-info.yml.twig', $vars);
    $this->files[$prefix . '.module'] = $this->render('d8/module.twig', $vars);
    $this->files[$prefix . '.install'] = $this->render('d8/install.twig', $vars);
    $this->files[$prefix . '.libraries.yml'] = $this->render('d8/yml/libraries.yml.twig', $vars);
    $this->files[$prefix . '.services.yml'] = $this->render('d8/yml/services.yml.twig', $vars);
    $this->files[$prefix . '.permissions.yml'] = $this->render('d8/yml/permissions.yml.twig', $vars);

    $js_path = $vars['machine_name'] . '/js/' . str_replace('_', '-', $vars['machine_name']) . '.js';
    $this->files[$js_path] = $this->render('d8/javascript.twig', $vars);

    $class_prefix = Utils::camelize($vars['name']);

    $service_class = $class_prefix . 'Example';
    $this->files[$vars['machine_name'] . '/src/' . $service_class . '.php'] = $this->render(
      'd8/service/custom.twig',
      $vars + ['class' => $service_class]
    );

    $middleware_class = $class_prefix . 'Middleware';
    $this->files[$vars['machine_name'] . '/src/' . $middleware_class . '.php'] = $this->render(
      'd8/service/middleware.twig',
      $vars + ['class' => $middleware_class]
    );

    $subscriber_class = $class_prefix . 'Subscriber';
    $this->files[$vars['machine_name'] . '/src/EventSubscriber/' . $subscriber_class . '.php'] = $this->render(
      'd8/service/event-subscriber.twig',
      $vars + ['class' => $subscriber_class]
    );

    $this->files[$prefix . '.services.yml'] = $this->render(
      'd8/yml/services.yml.twig',
      $vars + ['class' => $class_prefix]
    );

    $block_vars['plugin_label'] = 'Example';
    $block_vars['plugin_id'] = $vars['machine_name'] . '_' . Utils::human2machine($block_vars['plugin_label']);
    $block_vars['category'] = $vars['name'];
    $block_vars['class'] = 'ExampleBlock';

    $this->files[$vars['machine_name'] . '/src/Plugin/Block/' . $block_vars['class'] . '.php'] = $this->render(
      'd8/plugin/block.twig',
      $vars + $block_vars
    );

    $controller_class = $class_prefix . 'Controller';
    $this->files[$prefix . '.routing.yml'] = $this->render('d8/yml/routing.yml.twig', $vars + ['class' => $controller_class]);
    $controller_path = $vars['machine_name'] . "/src/Controller/$controller_class.php";
    $this->files[$controller_path] = $this->render('d8/controller.twig', $vars + ['class' => $controller_class]);

    $form_path = $vars['machine_name'] . '/src/Form/SettingsForm.php';
    $this->files[$form_path] = $this->render('d8/form/config.twig', $vars + ['class' => 'SettingsForm']);
  }

}
