<?php

/**
 * ARCHIVO QUE CONTINENE LAS FUNCIONES QUE SE LLAMAN CUANDO SE ACCEDE A UNA RUTA
 */

/**
 * @file
 * Module file for Drupal hello
 * This module says hello!
 */

namespace Drupal\drupal_hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\UserInterface;

class DrupalHelloController extends ControllerBase {

  // FUNCION QUE SE LLAMA CUANDO SE ACCEDE A LA RUTA http://curso-drupal.dev.com/hello
  public function hello() {
    return array('#markup' => "<p>" . $this->t(string: 'Hello my friend welcome to my website!') . "</p>");
  }

  /**
   * FUNCION QUE SE LLAMA CUANDO SE ACCEDE A LA RUTA http://curso-drupal.dev.com/sum
   * RECIBE PARAMETROS
   */
  public function sum($number_one, $number_two) {
    dpm($number_one);
    return array('#markup' => $number_one . "+" . $number_two . "=" . $number_one + $number_two);
  }

  /**
   * FUNCION QUE SE LLAMA CUANDO SE ACCEDE A LA RUTA http://curso-drupal.dev.com/get/user
   * RECIBE PARAMETROS
   */
  public function get_user(UserInterface $user) {
    $currentUser = $user->toArray();
    dpm($user->toArray());
    #return array('#markup' => "The current user is: " . $currentUser['name'][0]['value']);
    return array('#markup' => "The current user is: " . $user->getAccountName());
  }
}
