<?php

namespace Drupal\drupalup_simple_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Our simple form class.
 */
class SimpleForm extends FormBase {

  /**
   * This function is for form id.
   *
   * @return formId
   *   Return only form id.
   */
  public function getFormId() {
    $formId = 'drupalup_simple_form';
    return $formId;
  }

  /**
   * Build form fields.
   *
   * @param array $form
   *   Form buldup array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   It will retrieve the value of form.
   *
   * @return form
   *   Form fields.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['time'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Time'),
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Calculate'),
    ];
    return $form;
  }

  /**
   * After form sub mission.
   *
   * @param array $form
   *   Form data.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   It will retrieve the value of form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $time = $form_state->getValue('time');
    if ($time > "12" && $time < "15") {
      $msg = 'Good Noon';
    } else {
      $msg = 'Sorry! Time is not define in our system';
    }
    \Drupal::messenger()->addMessage($msg);
  }
}
