<?php

namespace Drupal\configurationFrom\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * This class is generate a configuration form.
 */
class SettingsForm extends ConfigFormBase
{
  /**
   * Undocumented function.
   *
   * @return setting
   *   Return editable config name.
   */

  protected function getEditableConfigNames()
  {
    $setting = [
      'configurationFrom.settings',
    ];
    return $setting;
  }
  /**
   * This function is for form id.
   *
   * @return formId
   *   Return only form id.
   */
  public function getFormId()
  {
    $formId = 'settings_form';
    return $formId;
  }
  /**
   * Build form fields.
   *
   * @param array $form
   *   Form buldup array.
   * @param FormStateInterface $form_state
   *   An.
   *
   * @return form
   *   Form fields.
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('configurationFrom.settings');

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => 'India',
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => 'Kolkata',
    ];

    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => $config->get('api_key'),
    ];

    $form['api_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Endpoint'),
      '#default_value' => $config->get('api_endpoint'),
    ];
    return parent::buildForm($form, $form_state);
  }
  /**
   * Submit handler function.
   *
   * @param array $form
   *   Form buldup array.
   * @param FormStateInterface $form_state
   *   Aa.
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    parent::submitForm($form, $form_state);
    $this->config('configurationFrom.settings')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('api_key', $form_state->getValue('api_key'))
      ->set('api_endpoint', $form_state->getValue('api_endpoint'))
      ->save();
  }

}
