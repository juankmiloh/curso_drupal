(function ($, Drupal) {
    'use strict';
  
    Drupal.behaviors.myBehavior = {
      attach: function (context, settings) {
        // Seleccionar el elemento #edit-adopted-pet dentro del contexto actual.
        var $editAdoptedPet = $('#edit-adopted-pet', context);
  
        // Verificar si el elemento existe.
        if ($editAdoptedPet.length) {
          // Verificar si ya se ha adjuntado el comportamiento.
          if (!$editAdoptedPet.data('myBehaviorAttached')) {
            // Agregar un evento change al elemento seleccionado.
            $editAdoptedPet.on('change', function () {
              var pet_id = $(this).val();
              console.log(pet_id);
              $.ajax({
                url: '/take_a_pet/change_photo',
                type: 'POST',
                data: ({pet_id:pet_id}),
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                }
              });
  
              // Aquí puedes agregar la lógica adicional que desees en respuesta al cambio.
            });
  
            // Marcar que se ha adjuntado el comportamiento para evitar duplicados.
            $editAdoptedPet.data('myBehaviorAttached', true);
          }
        }
      }
    };
  })(jQuery, Drupal);
  