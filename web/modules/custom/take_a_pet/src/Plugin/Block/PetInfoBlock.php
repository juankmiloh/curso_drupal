<?php

namespace Drupal\take_a_pet\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a pet info Block
 * 
 * @Block (
 * id = "pet_info_block",
 * admin_label = @Translation("Pet Info BLock")
 * )
 */

 class PetInfoBlock extends BlockBase {
    public function build() {
        $path = "https://cdn.pixabay.com/photo/2018/04/27/19/11/anonymous-3355586_960_720.png";
        return [
            '#markup' =>"<div id='pet_info'>
                            <img id='pet_image' src='$path'>
                            <h3 id='pet_name'>Select a pet</h3>
                            <h3 id='pet_age'></h3>
                            <h3 id='foundation_name'></h3>
                            <h3 id='foundation_email'></h3>
                        </div>"
        ];
    }
 }