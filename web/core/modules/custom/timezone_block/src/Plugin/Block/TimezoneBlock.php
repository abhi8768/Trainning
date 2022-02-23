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

  public function build()
  {
    return [
        '#markup' => $this->getValue(),
        '#cache'  => [
          'max-age' => 0,
        ],
    ];
  }

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
