<?php

namespace DrupalCodeGenerator\Commands\Drupal_8\Module;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DrupalCodeGenerator\Commands\BaseGenerator;

/**
 * Implements d8:module:standard command.
 */
class Standard extends BaseGenerator {

  protected $name = 'd8:module:standard';
  protected $description = 'Generates standard Drupal 8 module';
  protected $alias = 'module';

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {

    $questions = [
      'name' => ['Module name', [$this, 'defaultName']],
      'machine_name' => ['Module machine name', [$this, 'defaultMachineName']],
      'description' => ['Module description', 'TODO: Write description for the module'],
      'package' => ['Package', 'custom'],
      'version' => ['Version', '8.x-1.0-dev'],
      'dependencies' => ['Dependencies (comma separated)', '', FALSE],
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
    $this->files[$vars['machine_name'] . '/js/' . $vars['machine_name'] . '.js'] = $this->render('d8/javascript.twig', $vars);

    $service_class = $this->human2class($vars['name'] . 'Example');
    $this->files[$vars['machine_name'] . '/src/' . $service_class . '.php'] = $this->render(
      'd8/service.twig',
      $vars + ['class' => $service_class]
    );

    $middleware_class = $this->human2class($vars['name'] . 'Middleware');
    $this->files[$vars['machine_name'] . '/src/' . $middleware_class . '.php'] = $this->render(
      'd8/middleware.twig',
      $vars + ['class' => $middleware_class]
    );

    $subscriber_class = $this->human2class($vars['name'] . 'Subscriber');
    $this->files[$vars['machine_name'] . '/src/EventSubscriber/' . $subscriber_class . '.php'] = $this->render(
      'd8/event-subscriber.twig',
      $vars + ['class' => $subscriber_class]
    );

    $this->files[$prefix . '.services.yml'] = $this->render(
      'd8/yml/services.yml.twig',
      $vars + ['class' => $this->human2class($vars['name'])]
    );

    $block_vars['plugin_label'] = 'Example';
    $block_vars['plugin_id'] = $vars['machine_name'] . '_' . $this->human2machine($block_vars['plugin_label']);
    $block_vars['category'] = $vars['name'];
    $block_vars['class'] = $this->human2class($block_vars['plugin_label'] . 'Block');

    $this->files[$vars['machine_name'] . '/src/Plugin/Block/' . $block_vars['class'] . '.php'] = $this->render(
      'd8/plugin/block.twig',
      $vars + $block_vars
    );

    $controller_class = $this->human2class($vars['name'] . 'Controller');
    $this->files[$prefix . '.routing.yml'] = $this->render('d8/yml/routing.yml.twig', $vars + ['class' => $controller_class]);
    $controller_path = $vars['machine_name'] . "/src/Controller/$controller_class.php";
    $this->files[$controller_path] = $this->render('d8/controller.twig', $vars + ['class' => $controller_class]);

    $form_path = $vars['machine_name'] . '/src/Form/SettingsForm.php';
    $this->files[$form_path] = $this->render('d8/form/config.twig', $vars + ['class' => 'SettingsForm']);

  }

}
