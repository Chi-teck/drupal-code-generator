<?php

namespace Drupal\foo\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Connection;
use Drupal\Core\Form\ConfirmFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a confirmation form before clearing out the examples.
 */
class ExampleConfirmForm extends ConfirmFormBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * Constructs new ExampleConfirmForm object.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   *
   * @DCG: Optional.
   */
  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'foo_example_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete all examples?');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('foo.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->connection->delete('examples')->execute();
    drupal_set_message($this->t('Examples cleared.'));
    $form_state->setRedirectUrl($this->getCancelUrl());
  }

}
