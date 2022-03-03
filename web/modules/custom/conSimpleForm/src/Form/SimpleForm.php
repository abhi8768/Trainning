<?php

namespace Drupal\conSimpleForm\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * This class is generate a simple form.
 */
class SimpleForm extends FormBase
{

  /**
   * This function is for form id.
   *
   * @return formId
   *   Return only form id.
   */
  public function getFormId()
  {
    return 'conSimpleForm';
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
        '#title' => $this->t('State'),
        '#pattern' => '[A-Za-z]*',
      ];
      $form['names_fieldset'][$i]['city'] = [
        '#type' => 'textfield',
        '#title' => $this->t('City'),
        '#pattern' => '[A-Za-z]*',
      ];
    }

    $form['add_name'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add one more'),
      '#submit' => ['::addMore'],
      '#ajax' => [
        'callback' => '::addMoreCallback',
        'wrapper' => 'names-fieldset-wrapper',
      ],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }
  /**
   * Add more row function.
   *
   * @param array $form
   *   Form buldup array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   It will retrieve the value of form.
   */
  public function addMore(array $form, FormStateInterface $form_state)
  {
    $currentNum = $form_state->get('num_names');
    $currentNum = $currentNum + 1;
    $form_state->set('num_names', $currentNum);
    $form_state->setRebuild();
  }
  /**
   * Add more call back function.
   *
   * @param array $form
   *   Form buldup array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   It will retrieve the value of form.
   *
   * @return returnValue
   *   Return name field set.
   */
  public function addMoreCallback(array $form, FormStateInterface $form_state)
  {
    $returnValue = $form['names_fieldset'];
    return $returnValue;
  }

  /**
   * Submit handler function.
   *
   * @param array $form
   *   Form buldup array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   It will retrieve the value of form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
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
