<?php
namespace App\Models;

use Requtize\QueryBuilder\Connection;
use Requtize\QueryBuilder\QueryBuilder\QueryBuilderFactory;
use Requtize\QueryBuilder\ConnectionAdapters\PdoBridge;
use App\Libraries\Database;

class ListItem {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();  
    }

    public function get_by_list_id($list_id) {
        $conn = new Connection(new PdoBridge($this->pdo));
        $qbf = new QueryBuilderFactory($conn);
        $result = $qbf->from('shopping_list_items')
            ->where('shopping_list_id', '=', $list_id)
            ->all();
        return $result;
    }

    public function save($data) {
        // Prepare and execute SQL query to insert list item data
        $conn = new Connection(new PdoBridge($this->pdo));
        $qbf = new QueryBuilderFactory($conn);
        $result = $qbf->insert($data, 'shopping_list_items');
        return $result;
    }

    public function update($id, $data) {
        // Prepare and execute SQL query to update list item data
        $conn = new Connection(new PdoBridge($this->pdo));
        $qbf = new QueryBuilderFactory($conn);
        $result = $qbf
        ->from('shopping_list_items')
        ->where('id', $id)
        ->update($data);
        
        return $result;
    }
    

    public function delete($id) {
        $conn = new Connection(new PdoBridge($this->pdo));
        $qbf = new QueryBuilderFactory($conn);
        $result = $qbf
        ->from('shopping_list_items')
        ->where('id', $id)
        ->delete();
        return $result;
    }
}