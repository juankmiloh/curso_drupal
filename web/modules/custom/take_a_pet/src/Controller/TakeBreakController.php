<?php

namespace Drupal\take_a_pet\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class TakeBreakController extends ControllerBase {
    
    public function change_photo() {
        return new JsonResponse(['true' => TRUE]);
    }
}