<?php

/**
 * @file Providing database operations
 */

namespace Drupal\take_a_pet;

class DatabaseOperationServices {

    public function get_adopters($input) {
        $adopters = \Drupal::entityTypeManager()->getStorage(entity_type_id: 'node')
            ->loadByProperties(['type' => 'adopter']);
        return $adopters;
    }
}