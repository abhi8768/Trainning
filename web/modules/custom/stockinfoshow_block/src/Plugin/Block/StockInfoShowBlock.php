<?php

namespace Drupal\stockinfoshow_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use GuzzleHttp\Client;

/**
 * Provides a 'Stock Information Show Block' Block.
 *
 * @Block(
 *   id = "stockinfoshowBlock",
 *   admin_label = @Translation("Stock Information Show block"),
 *   category = @Translation("stockinfoshowBlock"),
 * )
 **/
class StockInfoShowBlock extends BlockBase
{
  /**
   * Generate a block.
   *
   * @return block
   *   Return a block data.
   */

  public function build()
  {
    $block = [
      '#markup' => $this->getValue(),
      '#cache'  => [
        'max-age' => 0,
      ],
    ];
    return $block;
  }
  /**
   * Fetch the data of a form.
   *
   * @return msg
   *   Return a message data.
   */
  private function getValue()
  {
    $config = \Drupal::config('stockinformation_block.settings');

    $companyName = $config->get('companyName');
    $startDate = $config->get('start_date');
    $endDate = $config->get('end_date');

    $desUrl = 'https://api.tiingo.com/tiingo/daily/company_token';
    $companyName = strtolower($companyName);
    $desUrl = str_replace("company_token", $companyName, $desUrl);

    $client = new Client([
      'base_uri' => $desUrl,
    ]);

    $response = $client->request('GET', '', [
        'query' => [
          'token' => '34f412d51db4046a81f4180aad2233c41df5d3b1',
        ]
    ]);

    $body = $response->getBody();
    $dataFirst = json_decode($body);
    $company_name = $dataFirst->name;
    $description = $dataFirst->description;

    if ($startDate == '') {
      $startDate = date('Y-m-d');
    }
    if ($endDate == '') {
      $endDate = date('Y-m-d');
    }

    $priceUrl = 'https://api.tiingo.com/tiingo/daily/compName/prices';
    $companyName = strtolower($companyName);
    $priceUrl = str_replace("compName", $companyName, $priceUrl);

    $clientPrice = new Client([
      'base_uri' => $priceUrl,
    ]);
    $responsedata = $clientPrice->request('GET', '', [
        'query' => [
          'startDate' => $startDate,
          'endDate' => $endDate,
          'token' => '34f412d51db4046a81f4180aad2233c41df5d3b1',
        ]
    ]);

    $resultS = $responsedata->getBody();
    $data = json_decode($resultS);

    $priceMsg = '';
    foreach ($data as $value) {
      $fdate = $value->date;
      $maxPrice = $value->high;
      $lowPrice = $value->low;
      $priceMsg .= 'Date : ' . $fdate . '; Max Price : ' . $maxPrice . '; Low Prie : ' . $lowPrice . '<br><br>';
    }

    $nameDesc = 'Company Name : ' . $company_name . '<br> Description : ' . $description . '<br><br>';
    $msg = $nameDesc . $priceMsg;
    return $msg;
  }

}
