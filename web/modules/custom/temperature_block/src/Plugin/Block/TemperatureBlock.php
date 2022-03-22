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
class TemperatureBlock extends BlockBase {

  /**
   * Generate a block.
   *
   * @return block
   *   Return a block data.
   */
  public function build() {
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
  private function getValue() {
    $config = \Drupal::config('configurationFrom.settings');
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

    $msg = 'Current Temperature for ' . $city . ' : ' . $tempInCelcius . ' C';
    return $msg;
  }
}
