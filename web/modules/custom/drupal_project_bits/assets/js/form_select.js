(function ($, Drupal) {
    'use strict';
  
    Drupal.behaviors.myBehavior = {
      attach: function (context, settings) {
        // Seleccionar el elemento #edit-departamentodentro del contexto actual.
        var $selectDepartamento = $('#edit-departamento', context);
        var $selectCiudad = $('#edit-ciudad', context);
        var citySelect = document.getElementById('edit-ciudad');
  
        // Verificar si el elemento existe.
        if ($selectDepartamento.length) {
          // Verificar si ya se ha adjuntado el comportamiento.
          if (!$selectDepartamento.data('myBehaviorAttached')) {
            // Agregar un evento change al elemento seleccionado.
            $selectDepartamento.on('change', function () {
              var dpto_id = $(this).val();
              console.log(dpto_id);
              $.ajax({
                url: '/drupal_project_bits/change_options',
                type: 'POST',
                data: ({dpto_id:dpto_id}),
                dataType: 'JSON',
                success: function (data) {
                    console.log('data :>> ', data);
                    $selectCiudad.empty(); // Elimina las opciones anteriores
                    // $.each(data, function (key, obj) {
                    //     console.log(obj);
                    //     $selectCiudad.append($('<option>', {
                    //         value: obj.value,
                    //         text: obj.text
                    //     }));
                    // });
                    data.forEach(function(city) {
                        console.log('city :>> ', city);
                        var option = document.createElement('option');
                        option.value = city.value;
                        option.text = city.text;
                        citySelect.appendChild(option);
                    });
                }
              });
            });
  
            // Marcar que se ha adjuntado el comportamiento para evitar duplicados.
            $selectDepartamento.data('myBehaviorAttached', true);
          }
        }
      }
    };
})(jQuery, Drupal);
