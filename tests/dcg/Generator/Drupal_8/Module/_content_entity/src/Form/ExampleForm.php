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

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New example %label has been created.', $message_arguments));
      $this->logger('foo')->notice('Created new example %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The example %label has been updated.', $message_arguments));
      $this->logger('foo')->notice('Created new example %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.foo_example.canonical', ['foo_example' => $entity->id()]);
  }

}
