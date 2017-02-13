<?php

namespace Drupal\foo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Component\Utility\Unicode;

/**
 * Provides a Foo form.
 */
class ExampleForm extends FormBase {

  /**
   * @var LoggerChannelFactory
   */
  protected $logger;

  /**
   * Constructs a ExampleForm object.
   *
   * @param  LoggerChannelFactory $logger_factory
   *   A logger instance.
   * 
   * @DCG: Optional.
   */
  public function __construct(LoggerChannelFactory $logger_factory) {
    $this->loggerFactory = $logger_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('logger.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'foo_example';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#required' => TRUE,
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => t('Save'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (Unicode::strlen($form_state->getValue('message')) < 10) {
      $form_state->setErrorByName('name', $this->t('Message should be at least 10 charaters.'));
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->loggerFactory->get('foo')->debug(
      $form_state->getValue('message')
    );
    drupal_set_message($this->t('The message has been sent.'));
    $form_state->setRedirect('system.admin');
  }

}
