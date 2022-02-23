<?php

namespace Drupal\stockinfoshow_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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
    $config = \Drupal::config('stockinformation_block.settings');
    $companyName = $config->get('companyName');
    $start_date = $config->get('start_date');
    $end_date = $config->get('end_date');

    $desUrl = 'https://api.tiingo.com/tiingo/daily/company_token?token=34f412d51db4046a81f4180aad2233c41df5d3b1';
    $companyName = strtolower($companyName);
    $desUrl = str_replace("company_token", $companyName, $desUrl);
    $result1 = $this->callAPI($desUrl);
    $data1 = json_decode($result1);
    $company_name = $data1->name;
    $description = $data1->description;

    if($start_date == '')
    {
      $start_date = date('Y-m-d');
    }
    if($end_date == '')
    {
      $end_date = date('Y-m-d');
    }
    $priceUrl = 'https://api.tiingo.com/tiingo/daily/aapl/prices?startDate=start_date&endDate=end_date&token=34f412d51db4046a81f4180aad2233c41df5d3b1';
    $companyName = strtolower($companyName);
    $priceUrl = str_replace("start_date", $start_date, $priceUrl);
    $priceUrl = str_replace("end_date", $end_date, $priceUrl);
    $result2 = $this->callAPI($priceUrl);
    $data = json_decode($result2);
    $priceMsg = '';
    foreach($data as $value)
    {
      $fdate = $value->date;
      $max_price = $value->high;
      $low_price = $value->low;
      $priceMsg.= 'Date : ' . $fdate . '; Max Price : ' . $max_price . '; Low Prie : ' . $low_price . '<br><br>';
    }

    $nameDesc = 'Company Name : ' . $company_name . '<br> Description : ' . $description . '<br><br>';
    $msg = $nameDesc . $priceMsg;
    return $msg;
  }
  private function callAPI($url)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
  }


}
