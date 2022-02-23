<?php

namespace Drupal\stockinformation_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Stock Information' Block.
 *
 * @Block(
 *   id = "stockinformation_block",
 *   admin_label = @Translation("Stock Information block"),
 *   category = @Translation("abhi"),
 * )
 */
class StockinformationBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $form = \Drupal::formBuilder()->getForm('Drupal\stockinformation_block\Form\StockForm');
    return $form;
  }

}
