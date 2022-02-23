<?php

namespace Drupal\hello_world\Controller;

class HelloController
{
  public function welcome()
  {
    $service = \Drupal::service('hello_world.say');
        return array(
          '#type' => 'markup',
          '#markup' => $service->sayHello('')
        );
  }
  public function content($name)
  {
    $service = \Drupal::service('hello_world.say');
        return array(
          '#type' => 'markup',
          '#markup' => $service->sayHello($name),
        );
  }


}
