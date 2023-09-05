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
                            <div><b>Name: </b><span id='pet_name'>Select a pet</span></div>
                            <div><b>Address: </b><span id='pet_age'>Select a pet</span></div>
                            <div><b>Foundation: </b><span id='foundation_name'>Select a pet</span></div>
                            <div><b>Description: </b><span id='foundation_email'>Select a pet</span></div>
                            </div>
                        </div>"
        ];
    }
}