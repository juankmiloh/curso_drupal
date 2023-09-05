<?php

namespace Drupal\drupal_project_bits\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

class RegisterForm extends FormBase {
    public function getFormId() {
        return 'register_form';
    }   

    public function buildForm(array $form, FormStateInterface $form_state) {
        $departments = \Drupal::entityTypeManager()->getStorage(entity_type_id: 'node')->loadByProperties(['type' => 'departamento']);
        $departments_array = [];
        foreach ($departments as $department) {
            $departments_array[$department->id()] = $department->label();
        }

        $cities = \Drupal::entityTypeManager()->getStorage(entity_type_id: 'node')->loadByProperties(['type' => 'ciudad']);
        $cities_array = [];
        foreach ($cities as $city) {
            $cities_array[$city->id()] = $city->label();
        }

        $companies = \Drupal::entityTypeManager()->getStorage(entity_type_id: 'node')->loadByProperties(['type' => 'empresa']);
        $companies_array = [];
        foreach ($companies as $company) {
            $companies_array[$company->id()] = $company->label();
        }

        $form['first_form'] = [
            '#type' => 'details',
            '#title' => $this->t(string: 'Primer Paso - Información Básica'),
            '#description' => $this->t(string: 'Registra tu información'),
            '#open' => TRUE
        ];
        
        $form['second_form'] = [
            '#type' => 'details',
            '#title' => $this->t(string: 'Segundo Paso - Información Laboral'),
            '#description' => $this->t(string: 'Finaliza tu registro'),
            '#open' => FALSE
        ];

        $form['first_form']['nombre'] = [
            '#type' => 'textfield',
            '#title' => $this->t(string: 'Nombre'),
            '#description' => $this->t(string: ''),
            '#maxlength' => 255,
            '#size' => 255,
            '#weight' => '0',
            '#required' => TRUE
        ];

        $form['first_form']['edad'] = [
            '#type' => 'number',
            '#title' => $this->t(string: 'Edad'),
            '#description' => $this->t(string: ''),
            '#weight' => '0',
            '#required' => TRUE,
            '#attributes' => ['style' => 'width: 100%;'],
        ];

        $form['first_form']['genero'] = [
            '#type' => 'radios',
            '#title' => $this->t('Género'),
            '#options' => [
                'masculino' => $this->t('Masculino'),
                'femenino' => $this->t('Femenino'),
            ],
            '#default_value' => 'masculino', // Opción predeterminada seleccionada.
            '#weight' => '0',
        ];

        $form['first_form']['departamento'] = [
            '#type' => 'select',
            '#title' => $this->t(string: 'Departamento'),
            '#options' => $departments_array,
            '#empty_option' => 'Seleccione un departamento',
            '#description' => $this->t(string: ''),
            '#required' => TRUE,
            '#attributes' => ['style' => 'width: 100%;'],
        ];

        $form['first_form']['ciudad'] = [
            '#type' => 'select',
            '#title' => $this->t(string: 'Ciudad'),
            '#options' => $cities_array,
            // '#options' => [],
            '#empty_option' => 'Seleccione una ciudad',
            '#description' => $this->t(string: ''),
            '#required' => TRUE,
            '#attributes' => ['style' => 'width: 100%;'],
        ];

        $form['second_form']['empresa'] = [
            '#type' => 'select',
            '#title' => $this->t(string: 'Empresa'),
            '#options' => $companies_array,
            '#empty_option' => 'Seleccione una empresa',
            '#description' => $this->t(string: ''),
            '#required' => TRUE,
            '#attributes' => ['style' => 'width: 100%;'],
        ];

        $form['second_form']['tiempo_laborado'] = [
            '#type' => 'number',
            '#title' => $this->t(string: 'Tiempo Laborado'),
            '#description' => $this->t(string: ''),
            '#weight' => '0',
            '#required' => TRUE,
            '#attributes' => ['style' => 'width: 100%;'],
        ];

        $form['second_form']['salario'] = [
            '#type' => 'number',
            '#title' => $this->t(string: 'Salario'),
            '#description' => $this->t(string: ''),
            '#weight' => '0',
            '#required' => TRUE,
            '#attributes' => ['style' => 'width: 100%;'],
        ];

        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t(string: 'Submit')
        ];

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {}
}