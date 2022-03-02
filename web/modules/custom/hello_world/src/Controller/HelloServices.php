<?php

namespace Drupal\hello_world\Controller;

/**
 * Simple hello world class generate hello world information.
 */
class HelloServices
{
  /**
   * Print hello world with good morning.
   *
   * @param string $name
   *   Name veriable passing from url.
   *
   * @return message
   *   hello name with msg
   */

  public function sayHello($name = '')
  {
    if (empty($name)) {
      $hello = 'Hello World!';
    } else {
      $hello = 'Hello ' . $name . '!';
    }
    $time = date("H");
    if ($time > "6" && $time < "12") {
      $msg = 'Good Morning';
    } elseif ($time > "12" && $time < "17") {
      $msg = 'Good Afternoon';
    } elseif ($time > "17" && $time < "21") {
      $msg = 'Good Evening';
    } elseif ($time > "21" && $time < "6") {
      $msg = 'Good Night';
    }
    $message = $hello . ' ' . $msg . "!";
    return $message;
  }

}
