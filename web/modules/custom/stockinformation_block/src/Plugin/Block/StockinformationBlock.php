<?php

namespace Drupal\stockinformation_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Stock Information' Block.
 *
 * @Block(
 *   id = "stockinformation_block",
 *   admin_label = @Translation("Stock Information block"),
 *   category = @Translation("abhi"),
 * )
 */
/**
 * Generate a block with a form.
 */
class StockinformationBlock extends BlockBase
{
  /**
   * Build function simply generate a block.
   *
   * @return form
   *   Return form data.
   */

  public function build()
  {
    $form = \Drupal::formBuilder()->getForm('Drupal\stockinformation_block\Form\StockForm');
    return $form;
  }

}
