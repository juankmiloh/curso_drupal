<?php

namespace Drupal\take_a_pet\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Render\Renderer;

class AdoptForm extends FormBase {
    public function getFormId() {
        return 'adopt_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $pets = \Drupal::entityTypeManager()->getStorage(entity_type_id: 'node')->loadByProperties(['type' => 'pet', 'field_adopted' => FALSE]);
        $pets_array = [];
        foreach ($pets as $pet) {
            $pets_array[$pet->id()] = $pet->label();
        }

        $form['form_adopter'] = [
            '#type' => 'details',
            '#title' => $this->t(string: 'Form Adopter'),
            '#description' => $this->t(string: 'Add a new adoption'),
            '#open' => TRUE
        ];

        $form['form_adopter']['adopter_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t(string: 'Adopter Name'),
            '#description' => $this->t(string: 'The name must be at least 5 characters long'),
            '#maxlength' => 255,
            '#size' => 255,
            '#weight' => '0',
            '#required' => FALSE
        ];

        $form['form_adopter']['adopter_phone'] = [
            '#type' => 'number',
            '#title' => $this->t(string: 'Adopter Phone'),
            '#description' => $this->t(string: 'Adopter Phone'),
            '#weight' => '0',
            '#required' => FALSE
        ];

        $form['form_adopter']['adoption_date'] = [
            '#type' => 'date',
            '#title' => $this->t(string: 'Adoption Date'),
            '#description' => $this->t(string: 'Adoption Date'),
            '#weight' => '0',
            '#required' => FALSE,
            '#default_value' => date(format: 'Y-m-d'),
        ];

        $form['form_adopter']['adopted_pet'] = [
            '#type' => 'select',
            '#title' => $this->t(string: 'Adopted Pet'),
            '#options' => $pets_array,
            '#description' => $this->t(string: 'Adopted pet'),
            '#required' => TRUE,
        ];

        $form['form_adopter']['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t(string: 'Submit')
        ];

        $header = [
            [
                'data' => $this->t(string: 'Id'),
                'field' => 'id',
                'sort' => 'asc',
            ],
            ['data' => $this->t(string: 'Adopter Name'), 'field' => 'adopter_name'],
            ['data' => $this->t(string: 'Adopter Phone'), 'field' => 'phone'],
            ['data' => $this->t(string: 'Adoption Date'), 'field' => 'adoption_date'],
            ['data' => $this->t(string: 'Adopted Pet'), 'field' => 'adopted_pet'],
        ];
        $result = $this->getSearchData($header);
        $row = [];
        foreach ($result as $adoption) {
            $url = Url::fromRoute('entity.node.canonical', ['node' => $adoption->adopted_pet]);
            $entity = \Drupal::entityTypeManager()->getStorage(entity_type_id: 'node')->load($adoption->adopted_pet);
            $detail_link = Link::fromTextAndUrl(t($entity->label()), $url);
            $detail_link = $detail_link->toRenderable();
            $rows[] = [
                ['data' => $adoption->id],
                ['data' => $adoption->adopter_name],
                ['data' => $adoption->phone],
                ['data' => $adoption->adoption_date],
                ['data' => $detail_link]
            ];
        }

        $build[] = [
            '#theme' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#empty' => $this->t(string: 'No adoptions found.')
        ];

        $form['results'] = $build;

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $connection = Database::getConnection();
        $adopted_pet_id = $form_state->getValue(key: 'adopted_pet');
        $connection->insert(table: 'take_a_pet_adoption')
          ->fields([
            'adopter_name' => $form_state->getValue(key: 'adopter_name'),
            'phone' => $form_state->getValue(key: 'adopter_phone'),
            'adoption_date' => $form_state->getValue(key: 'adoption_date'),
            'adopted_pet' => $adopted_pet_id,
          ])
          ->execute();

        $selected_pet = Node::load($adopted_pet_id);
        $selected_pet->field_adopted->value = TRUE;
        $selected_pet->save();
        \Drupal::messenger()->addMessage(message: 'Adoption registered success!');
    }

    public function getSearchData($header) {
        $db = \Drupal::database();
        $query = $db->select(table: 'take_a_pet_adoption', alias: 'e');
        $query->fields(table_alias: 'e');
        $table_sort = $query->extend(extender_name: 'Drupal\Core\Database\Query\TableSortExtender')
            ->orderByHeader($header);
        $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender');
        $result = $pager->execute();
        return $result;
    }
}