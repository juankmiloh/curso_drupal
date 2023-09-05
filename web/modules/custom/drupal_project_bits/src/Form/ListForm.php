<?php

namespace Drupal\drupal_project_bits\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class ListForm extends FormBase {
    public function getFormId() {
        return 'list_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $header = [
            [
                'data' => $this->t(string: 'Registro'),
                'field' => 'id',
                'sort' => 'asc'
            ],
            ['data' => $this->t(string: 'Nombre'), 'field' => 'nombre'],
            ['data' => $this->t(string: 'Edad'), 'field' => 'edad'],
            ['data' => $this->t(string: 'Genero'), 'field' => 'genero'],
            ['data' => $this->t(string: 'Departamento'), 'field' => 'departamento'],
            ['data' => $this->t(string: 'Ciudad'), 'field' => 'ciudad'],
            ['data' => $this->t(string: 'Empresa'), 'field' => 'empresa'],
            ['data' => $this->t(string: 'Tiempo'), 'field' => 'tiempo_laborado'],
            ['data' => $this->t(string: 'Salario'), 'field' => 'salario'],
        ];
        $rows[] = [];
        $result = $this->getSearchData($header);
        foreach ($result as $register) {
            $departamento = Node::load($register->departamento);
            $ciudad = Node::load($register->ciudad);
            $empresa = Node::load($register->empresa);
            $rows[] = [
                ['data' => $register->id],
                ['data' => $register->nombre],
                ['data' => $register->edad],
                ['data' => $register->genero],
                ['data' => $departamento->title->value],
                ['data' => $ciudad->title->value],
                ['data' => $empresa->title->value],
                ['data' => $register->tiempo_laborado],
                ['data' => $register->salario],
            ];
        }

        $build[] = [
            '#theme' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#empty' => $this->t(string: 'No register found.'),
            '#attributes' => [
                'style' => 'border-collapse: collapse; border: 1px solid #ccc; width: 100%; text-align: center;',
                'cellpadding' => '4',
            ],
        ];

        $form['results'] = $build;

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {}

    public function getSearchData($header) {
        $db = \Drupal::database();
        $query = $db->select(table: 'drupal_project_bits_register', alias: 'e');
        $query->fields(table_alias: 'e');
        $table_sort = $query->extend(extender_name: 'Drupal\Core\Database\Query\TableSortExtender')
            ->orderByHeader($header);
        $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender');
        $result = $pager->execute();
        return $result;
    }
}