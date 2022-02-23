<?php

namespace Drupal\conSimpleForm\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Our simple form class.
 */
class SimpleForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'conSimpleForm';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $countryManager = \Drupal::service('country_manager');
    $list = $countryManager->getList();
    $countries = [];
    foreach ($list as $key => $value) {
      $val = $value->__toString();
      $countries[$val] = $val;
    }

    $form['country'] = [
      '#title' => t('Countries'),
      '#type' => 'select',
      '#options' => $countries,
    ];

    $form['#tree'] = TRUE;
    $form['names_fieldset'] = [
      '#type' => 'fieldset',
      '#prefix' => '<div id="names-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];

    if (empty($form_state->get('num_names'))) {
      $form_state->set('num_names', 1);
    }
    for ($i = 0; $i < $form_state->get('num_names'); $i++) {
      $form['names_fieldset'][$i]['state'] = [
        '#type' => 'textfield',
        '#title' => t('State'),
        '#pattern' => '[A-Za-z]*',
      ];
      $form['names_fieldset'][$i]['city'] = [
        '#type' => 'textfield',
        '#title' => t('City'),
        '#pattern' => '[A-Za-z]*',
      ];
    }

    $form['add_name'] = [
      '#type' => 'submit',
      '#value' => t('Add one more'),
      '#submit' => ['::broker_management_add_more_add_one'],
      '#ajax' => [
        'callback' => '::broker_management_add_more_callback',
        'wrapper' => 'names-fieldset-wrapper',
      ],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  public function broker_management_add_more_add_one($form, &$form_state) {
    $currentNum = $form_state->get('num_names');
    $currentNum = $currentNum + 1;
    $form_state->set('num_names', $currentNum);
    $form_state->setRebuild();
  }

  public function broker_management_add_more_callback($form, $form_state) {
    return $form['names_fieldset'];
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $country = $form_state->getValue('country');
    \Drupal::messenger()->addMessage('Your selected country is : ' . $country);
    \Drupal::messenger()->addMessage('Below are the locations you have entered');
    foreach ($form_state->getValue('names_fieldset') as $value) {
      for ($i = 0; $i < count($value); $i++) {
        \Drupal::messenger()->addMessage($value['state'] . "," . $value["city"]);
      }
    }
  }

}
