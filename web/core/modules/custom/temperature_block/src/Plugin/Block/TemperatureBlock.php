<?php

namespace Drupal\temperature_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Temparature Block' Block.
 *
 * @Block(
 *   id = "temperatureBlock",
 *   admin_label = @Translation("Temperature block"),
 *   category = @Translation("temperatureBlock"),
 * )
 **/
class TemperatureBlock extends BlockBase
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
    $config = \Drupal::config('configurationFrom.settings');
    $country = $config->get('country');
    $city = $config->get('city');
    $apiKey = $config->get('api_key');
    $apiEndpoint = $config->get('api_endpoint');
    $value = $this->callAPI($city, $apiKey, $apiEndpoint);
    $msg = 'Current Temperature for ' . $city . ' : ' . $value . ' C';
    return $msg;
  }
  private function callAPI($city, $apiKey, $apiEndpoint)
  {
    $url = 'https://' . $apiEndpoint;
    $url = str_replace("city", $city, $url);
    $url = str_replace("key", $apiKey, $url);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($output);
    $temp = $data->main->temp;
    $tempInCelcius = $temp - 273;
    return $tempInCelcius;
  }


}