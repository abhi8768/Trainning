<?php

namespace Drupal\temperature_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use GuzzleHttp\Client;

/**
 * Provides a 'Temparature Block' Block.
 *
 * @Block(
 *   id = "temperatureBlock",
 *   admin_label = @Translation("Temperature block"),
 *   category = @Translation("temperatureBlock"),
 * )
 */
class TemperatureBlock extends BlockBase
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
   * Fetch the data of a tempareture.
   *
   * @return msg
   *   Return a message data.
   */
  private function getValue()
  {
    $config = \Drupal::config('configurationFrom.settings');
    $country = $config->get('country');
    $city = $config->get('city');
    $apiKey = $config->get('api_key');
    $apiEndpoint = $config->get('api_endpoint');
    $url = 'https://' . $apiEndpoint;

     $client = new Client([
      'base_uri' => $url,
    ]);

    $response = $client->request('GET', '', [
        'query' => [
          'q' => $city,
          'appid' => $apiKey,
        ]
    ]);
    $output = $response->getBody();
    $data = json_decode($output);
    $temp = $data->main->temp;
    $tempInCelcius = $temp - 273;


    //$value = $this->callApi($city, $apiKey, $apiEndpoint);

    $msg = 'Current Temperature for ' . $city . ' : ' . $tempInCelcius . ' C';
    return $msg;
  }
  /**
   * Api call function using curl.
   *
   * @param string $city
   *   City name.
   * @param string $apiKey
   *   Api key value.
   * @param string $apiEndpoint
   *   Api url.
   *
   * @return tempInCelcius
   *   Return temperatue in celcious.
   */
  private function callApi($city, $apiKey, $apiEndpoint)
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
