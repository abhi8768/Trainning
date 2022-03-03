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
/**
 * This block is showing stock information data.
 */
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

    $desUrl = 'https://api.tiingo.com/tiingo/daily/company_token?token=34f412d51db4046a81f4180aad2233c41df5d3b1';
    $companyName = strtolower($companyName);
    $desUrl = str_replace("company_token", $companyName, $desUrl);
    $resultF = $this->callApi($desUrl);
    $dataFirst = json_decode($resultF);
    $company_name = $dataFirst->name;
    $description = $dataFirst->description;

    if ($startDate == '') {
      $startDate = date('Y-m-d');
    }
    if ($endDate == '') {
      $endDate = date('Y-m-d');
    }
    $priceUrl = 'https://api.tiingo.com/tiingo/daily/aapl/prices?startDate=start_date&endDate=end_date&token=34f412d51db4046a81f4180aad2233c41df5d3b1';
    $companyName = strtolower($companyName);
    $priceUrl = str_replace("start_date", $startDate, $priceUrl);
    $priceUrl = str_replace("end_date", $endDate, $priceUrl);
    $resultS = $this->callApi($priceUrl);
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
  /**
   * This function basically use the curl.
   *
   * @param string $url
   *   Url is used for fetching data.
   *
   * @return output
   *   Return the curl value.
   */
  private function callApi($url)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
  }

}
