<?php

namespace Drupal\foo\Plugin\views\argument_default;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\views\Plugin\views\argument_default\ArgumentDefaultPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * @DCG: Describe you plugin here.
 *
 * @ViewsArgumentDefault(
 *   id = "foo_example",
 *   title = @Translation("Example")
 * )
 */
class Example extends ArgumentDefaultPluginBase implements CacheableDependencyInterface {

  /**
   * The route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   *
   * @DCG: Optional.
   */
  protected $routeMatch;

  /**
   * Constructs a new Example instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match.
   *
   * @DCG: Optional.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    /**
     * @DCG: {
     * The Route match service is only needed if you want to extract argument
     * from the current route.
     * @DCG: }
     */
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['example_option'] = ['default' => ''];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['example_option'] = [
      '#type' => 'textfield',
      '#title' => t('Some example option'),
      '#default_value' => $this->options['example_option'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getArgument() {

    /**
     * @DCG: {
     * Here is the place where you should create a default argument for the
     * contextual filter. The source of this argument depends on your needs.
     * For example, you can extract the value from the URL or fetch it from
     * some fields of the current viewed entity.
     * @DCG: }
     */

    // @DCG: For now lets use example option as an argument.
    $argument = $this->options['example_option'];

    return $argument;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return Cache::PERMANENT;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return ['url'];
  }

}
