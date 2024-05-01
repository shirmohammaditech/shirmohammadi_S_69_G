<?php
namespace App\Models;

use Requtize\QueryBuilder\Connection;
use Requtize\QueryBuilder\QueryBuilder\QueryBuilderFactory;
use Requtize\QueryBuilder\ConnectionAdapters\PdoBridge;
use App\Libraries\Database;

class ShoppingList {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();  
    }

    public function get_by_user_id($user_id) {
        $conn = new Connection(new PdoBridge($this->pdo));
        $qbf = new QueryBuilderFactory($conn);
        $result = $qbf->from('shopping_lists')
            ->where('user_id', '=', $user_id)
            ->all();
        return $result;
    }

    public function save($user_id, $data) {
        // Prepare and execute SQL query to insert list data
        $data['user_id'] = $user_id;
        $conn = new Connection(new PdoBridge($this->pdo));
        $qbf = new QueryBuilderFactory($conn);
        $result = $qbf->insert($data, 'shopping_lists');
        return $result;
    }

    public function update($id, $data) {
        // Prepare and execute SQL query to update list data
        $conn = new Connection(new PdoBridge($this->pdo));
        $qbf = new QueryBuilderFactory($conn);
        $result = $qbf
        ->from('shopping_lists')
        ->where('id', $id);
        $result = $result->update($data);
        
        return $result;
    }
    

    public function delete($id) {
        $conn = new Connection(new PdoBridge($this->pdo));
        $qbf = new QueryBuilderFactory($conn);
        $result = $qbf
        ->from('shopping_lists')
        ->where('id', $id)
        ->delete();

        $delete_items = $qbf
        ->from('shopping_list_items')
        ->where('shopping_list_id', $id)
        ->delete();

        return $result;
    }
}