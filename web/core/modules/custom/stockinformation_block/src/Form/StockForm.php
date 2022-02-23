<?php

/**
 * @file
 * Contains Drupal\stockinformation_block\Form\StockForm.
 */

namespace Drupal\stockinformation_block\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class StockForm.
 *
 * @package Drupal\stockinformation_block\Form
 */
class StockForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'stockinformation_block.settings',
    ];
  }

  public function getFormId()
  {
    return 'StockForm';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
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

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

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
