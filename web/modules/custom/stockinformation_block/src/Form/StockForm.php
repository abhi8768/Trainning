<?php

namespace Drupal\stockinformation_block\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * This class basically generate a form of stock information.
 */
class StockForm extends ConfigFormBase {

  /**
   * Editable congif name function.
   *
   * @return setting
   *   Return editable config name.
   */
  protected function getEditableConfigNames()
  {
    $setting = [
      'stockinformation_block.settings',
    ];
    return $setting;
  }
  /**
   * Set form id.
   *
   * @return formId
   *   Return form id.
   */
  public function getFormId()
  {
    $formId = 'StockForm';
    return $formId;
  }

  /**
   * Generate form.
   *
   * @param array $form
   *   Form buldup array.
   * @param FormStateInterface $form_state
   *   An.
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('stockinformation_block.settings');

    $form['companyName'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Company Name'),
      '#default_value' => $config->get('companyName'),
    ];

    $form['start_date'] = [
      '#type' => 'date',
      '#title' => $this->t('Start Date'),
      '#default_value' => $config->get('start_date'),
    ];

    $form['end_date'] = [
      '#type' => 'date',
      '#title' => $this->t('End Date'),
      '#default_value' => $config->get('end_date'),
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
    $this->config('stockinformation_block.settings')
      ->set('companyName', $form_state->getValue('companyName'))
      ->set('start_date', $form_state->getValue('start_date'))
      ->set('end_date', $form_state->getValue('end_date'))
      ->save();
  }

}
