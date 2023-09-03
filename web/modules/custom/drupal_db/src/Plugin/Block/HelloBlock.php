<?php

namespace Drupal\drupal_db\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a Hello example Block
 * 
 * @Block(
 * id = "drupal_hello_block",
 * admin_label = @Translation("Drupal Hello Block")
 * )
 */

class HelloBlock extends BlockBase {

    public function build() {
        return [
            '#markup' => "<p>" . $this->t(string: 'Hello Block!') . "</p>"
        ];
    }
}