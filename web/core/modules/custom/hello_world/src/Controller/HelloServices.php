<?php

/**
* @file providing the service that say hello world and hello 'given name'.
*
*/

namespace  Drupal\hello_world\Controller;

class HelloServices
{
 protected $saySomething;

 public function __construct()
 {
    $this->saySomething = 'This is custom service!';
 }

 public function  sayHello($name = '')
 {
   if (empty($name)) {
     $hello = 'Hello World!';
   } else {
     $hello = 'Hello '.$name.'!';
   }
   $time = date("H");
     if($time > "6" && $time < "12"){
      $msg = 'Good Morning';
     }else if($time > "12" && $time < "17"){
      $msg = 'Good Afternoon';
     }else if($time > "17" && $time < "21"){
      $msg = 'Good Evening';
     }else if($time > "21" && $time < "6"){
      $msg = 'Good Night';
     }
     return $hello .' '. $msg . "!";
 }


}
