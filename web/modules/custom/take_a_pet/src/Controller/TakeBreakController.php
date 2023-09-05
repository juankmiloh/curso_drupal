<?php

namespace Drupal\take_a_pet\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Element\EntityAutocomplete;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TakeBreakController extends ControllerBase {
    
    public function change_photo(Request $request) {
        if ($request->isXmlHttpRequest()) {
            // return new JsonResponse(['true' => TRUE]);
            $pet_id = $request->request->get('pet_id');
            $selected_pet = Node::load($pet_id);
            $path = \Drupal::service('file_url_generator')->generateString($selected_pet->field_image->entity->getFileUri());
            return new JsonResponse([
                'path' => $path,
                'pet_name' => $selected_pet->label(),
                'pet_age' => $selected_pet->field_number->value,
                'foundation_name' => $selected_pet->field_foundation->entity->label(),
                'foundation_email' => $selected_pet->field_foundation->entity->field_email->value
            ]);
        }
        throw new \Exception('this is not an ajax call');
    }

    public function autocomplete_adopter(Request $request) {
        $results = [];
        $input = $request->query->get('q');
        if (!$input) {
            return new JsonResponse($results);
        }
        $input = Xss::filter($input);
        // Consulta los IDs de los nodos "adopter" que coincidan con el input.
        $adopters = \Drupal::service('database_operations')->get_adopters($input);

        foreach ($adopters as $adopter) {
            $title = $adopter->label(); // Nombre del adopter
            // Compara el título con la palabra ingresada.
            if (stripos($title, $input) !== false) {
                $results[] = [
                    'value' => EntityAutocomplete::getEntityLabels([$adopter]),
                    'label' => $adopter->label() . '(' . $adopter->id() . ')'
                ];
            }
        }
        return new JsonResponse($results);
    }
}