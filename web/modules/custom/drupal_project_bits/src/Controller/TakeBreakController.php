<?php

namespace Drupal\drupal_project_bits\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TakeBreakController extends ControllerBase {
    
    public function change_options(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $dpto_id = $request->request->get('dpto_id');
    
            $cities = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'ciudad', 'field_departamento' => $dpto_id]);
            $cities_array = [];
            foreach ($cities as $city) {
                // Para cada ciudad, crea un objeto con claves 'value' y 'text'.
                $cities_array[] = [
                    'value' => $city->id(),
                    'text' => $city->label(),
                ];
            }
            return new JsonResponse($cities_array);
        }
        throw new \Exception('This is not an Ajax call');
    }
}