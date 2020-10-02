<?php

namespace Drupal\foo\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the example entity edit forms.
 */
class FooExampleForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $message_arguments = ['%label' => $this->entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $this->entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New example %label has been created.', $message_arguments));
        $this->logger('foo')->notice('Created new example %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The example %label has been updated.', $message_arguments));
        $this->logger('foo')->notice('Updated example %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.foo_example.canonical', ['foo_example' => $entity->id()]);
  }

}
