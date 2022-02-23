<?php

namespace Drupal\drupalup_simple_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Our simple form class.
 */
class SimpleForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupalup_simple_form';
  }

  /**
   * {@inheritdoc}
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
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $time = $form_state->getValue('time');
    if($time > "12" && $time < "15"){
      $msg = 'Good Noon';
    }else{
      $msg = 'Sorry! Time is not define in our system';
    }
    \Drupal::messenger()->addMessage($msg);
  }

}
