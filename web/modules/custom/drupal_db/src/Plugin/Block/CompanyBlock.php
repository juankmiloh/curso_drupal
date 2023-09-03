<?php

namespace Drupal\drupal_db\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a Hello example Block
 * 
 * @Block(
 * id = "drupal_compay_block",
 * admin_label = @Translation("Drupal company block")
 * )
 */

class CompanyBlock extends BlockBase {
    public function build() {
        $build = [];
        $form = \Drupal::formBuilder()->getForm(form_arg: 'Drupal\drupal_db\Form\CompanyForm');
        $build['company_form'] = [
            'form' => $form
        ];
        return $build;
    }
}