<?php

/**
 * @file
 * Modulo File For database Class
 * This module insert, select, update and delete DB
 */

namespace Drupal\drupal_db\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class DrupalDatabaseController extends ControllerBase {

    public function insert() {
        $connection = Database::getConnection();
        $connection->insert(table: 'company')
            ->fields([
                'name' => 'EDteam',
                'address' => 'Global Company',
                'CEO' => 'Alvaro Felipe',
            ])
            ->execute();
        return array('#markup' => "<p>" . $this->t(string: 'Success!') . "</p>");
    }

    public function select() {
        $connection = Database::getConnection();
        $companies = $connection->select(table: 'company', alias: 'c')
            ->fields(table_alias: 'c')
            ->condition(field: 'c.name', value: 'JUANK', operator: '=')
            ->execute();
            foreach ($companies as $company) {
                dump($company);
            }
        return array('#markup' => "<p>" . $this->t(string: 'Success!') . "</p>");
    }

    public function update() {
        $connection = Database::getConnection();
        $connection->update(table: 'company')
            ->fields([
                'name' => 'Youtube',
                'address' => 'California'
            ])
            ->condition(field: 'id', value: 3)
            ->execute();
        return array('#markup' => "<p>" . $this->t(string: 'Success!') . "</p>");
    }

    public function delete() {
        $connection = Database::getConnection();
        $connection->delete(table: 'company')
            ->condition(field: 'id', value: 3)
            ->execute();
        return array('#markup' => "<p>" . $this->t(string: 'Success!') . "</p>");
    }
}