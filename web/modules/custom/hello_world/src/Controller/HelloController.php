<?php

namespace Drupal\hello_world\Controller;

/**
 * HelloController use the service and print message.
 */
class HelloController
{
  /**
   * Welcome function is default for url /welcome.
   *
   * @return markupArray
   *   display this message on website.
   */

  public function welcome()
  {
    $service = \Drupal::service('hello_world.say');
    $markupArray = [
      '#type' => 'markup',
      '#markup' => $service->sayHello(''),
    ];
    return $markupArray;
  }

  /**
   * This function execute when we type name after /welcome in url.
   *
   * @param string $name
   *   Name veriable passing from url.
   *
   * @return markupArray
   *   display this message on website.
   */
  public function content($name)
  {
    $service = \Drupal::service('hello_world.say');
    $markupArray = [
      '#type' => 'markup',
      '#markup' => $service->sayHello($name),
    ];
    return $markupArray;
  }

}
