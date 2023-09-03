<?php

namespace Drupal\drupal_db\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Ajax\Alert;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;


class CompanyForm extends FormBase {
    public function getFormId() {
        return 'company_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => $this->t(string: 'Company name'),
            '#description' => $this->t(string: 'The name must be at least 5 characters long'),
            '#required' => FALSE
        ];

        $form['address'] = [
            '#type' => 'textfield',
            '#title' => $this->t(string: 'Company Address'),
            '#description' => $this->t(string: 'Please add the company Address'),
            '#required' => FALSE
        ];

        $form['CEO'] = [
            '#type' => 'textfield',
            '#title' => $this->t(string: 'Company CEO'),
            '#description' => $this->t(string: 'Please add the company CEO'),
            '#required' => FALSE
        ];

        $form['tests'] = [
            '#type' => 'date',
            '#title' => $this->t(string: 'Test Field'),
            '#description' => $this->t(string: 'This a text Field'),
            '#required' => TRUE
        ];

        // $form['tests'] = [
        //     '#type' => 'select',
        //     '#title' => $this->t(string: 'Test Field'),
        //     '#description' => $this->t(string: 'This a text Field'),
        //     '#required' => TRUE,
        //     '#options' => [
        //         '1' => 'one',
        //         '2' => 'two',
        //         '3' => [
        //             '3.1' => 'tres punto uno',
        //             '3.2' => 'tres punto dos'
        //         ]
        //     ]
        // ];

        $form['actions'] = [ // Crea un contenedor que permite agrupar elementos [AGRUPADOR]
            '#type' => 'actions'
        ];

        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t(string: 'Submit')
        ];

        // $form['actions']['submit'] = [
        //     '#type' => 'submit',
        //     '#value' => $this->t(string: 'Submit'),
        //     '#ajax' => array(
        //         'callback' => '::SaveCompany',
        //         'effect' => 'fade',
        //         'progress' => array(
        //             'type' => 'throbber',
        //             'message' => NULL,
        //         ),
        //         'speed' => 'slow'
        //     )
        // ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        // $name = $form_state->getValue(key: 'name');
        // if (strlen($name) < 5) { // Si la longitud del campo no es de 5 caracteres
        //     // \Drupal::messenger()->addError(message: 'The company name must be at least 5 characters long');
        //     $form_state->setErrorByName(name: 'name', message: $this->t('The company name must be at least 5 characters long'));
        // }
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $date = $form_state->getValue(key: 'tests');
        dpm($date);
        $my_timestamp = strtotime($date);
        dpm($my_timestamp);
        $fecha = new \DateTime();
        $fecha->setTimestamp($my_timestamp);
        dpm($fecha->format(format: 'Y-M-D'));
    }

    // public function submitForm(array &$form, FormStateInterface $form_state) {
    //     $connection = Database::getConnection();
    //     $connection->insert(table: 'company')
    //         ->fields([
    //             'name' => $form_state->getValue(key: 'name'),
    //             'address' => $form_state->getValue(key: 'address'),
    //             'CEO' => $form_state->getValue(key: 'CEO'),
    //         ])
    //         ->execute();
    //     \Drupal::messenger()->addMessage(message: 'Company saved!');
    // }

    // public function SaveCompany(FormStateInterface $form_state) {
    //     $connection = Database::getConnection();
    //     $connection->insert('company')
    //         ->fields([
    //             'name' => $form_state->getValue('name'),
    //             'address' => $form_state->getValue('address'),
    //             'CEO' => $form_state->getValue('CEO'),
    //         ])
    //         ->execute();
    // }
}