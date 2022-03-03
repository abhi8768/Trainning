<?php

namespace Drupal\timezone_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Default Time Zone Block.
 *
 * @Block(
 *   id = "defaultTimeZoneBlock",
 *   admin_label = @Translation("Default Time Zone Block"),
 *   category = @Translation("defaultTimeZoneBlock"),
 * )
 **/
class TimezoneBlock extends BlockBase
{
  /**
   * This function is for creating a block.
   *
   * @return returnArray
   *   Display block message.
   */

  public function build()
  {
    $returnArray = [
      '#markup' => $this->getValue(),
      '#cache'  => [
        'max-age' => 0,
      ],
    ];
    return $returnArray;
  }
/**
 * Generate final message for different time zone.
 *
 * @return value
 *   Display final message.
 */
  private function getValue()
  {
    date_default_timezone_set('Asia/Kolkata');
    $indianTime = date('d-m-Y H:i');

    date_default_timezone_set('US/Eastern');
    $esternTime = date('d-m-Y H:i');

    date_default_timezone_set('America/Chicago');
    $centralTime = date('d-m-Y H:i');

    $value = 'Indian Standard Time : ' . $indianTime . '<br>Eastern Standard Time : ' . $esternTime.'<br>Central Standard Time : '.$centralTime;
    return $value;
  }

}
