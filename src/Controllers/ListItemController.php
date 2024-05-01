<?php
namespace App\Controllers;
session_start();
use App\Controller;
use App\Models\ListItem;

class ListItemController extends Controller
{
    public function index()
    {
        $list_id = $_GET['id'];
        $this->render('items', compact('list_id'));
    }

    public function getListItems()
    {
        var_dump($_GET['id']);
        die();
        if (!isset($_SESSION['loggedin'])) {
            header('Location: /');
            exit;
        } 
        $item = new ListItem();
        $list_items = $item->get_by_shopping_list_id($_POST['id']);
        $data = [];
        foreach($items as $index => $item) {
            $data[$item->id] = $item;
        }
        $result = array(
            'data' => $data
        );
        $this->render('items');
        header("Content-Type: application/json");
        http_response_code(200);
        
        echo json_encode($result);

    }

  
    public function createItem()
    {
        $item_data = array(
            'title' => htmlspecialchars(trim($_POST['title'])),
            'description' => htmlspecialchars(trim($_POST['description'])),
            'shopping_list_id' => htmlspecialchars(trim($_POST['shopping_list_id']))
        );
        $list_item = new ListItem();
        $inserted_item = $list_item->save($item_data);
        $item_data['id'] = $inserted_item;
        if ($inserted_item) {
            $this->_updateListItems($item_data['shopping_list_id']);
        } else {
            $response = array (
                'status' => false, //http status
                'code' => 500, // error code
                'message' => 'Error', // string message
                'data' => null
            );
            header("Content-Type: application/json");
            http_response_code(500);
            echo json_encode($response);
        }

    }


    public function editItem()
    {
        $item_data = array(
            'title' => htmlspecialchars(trim($_POST['title'])),
            'description' => htmlspecialchars(trim($_POST['description'])),
            'shopping_list_id' => htmlspecialchars(trim($_POST['shopping_list_id']))
        );

        $id = (int) $_POST['id']; 
        $list_item = new ListItem();
        $updated_item = $list_item->update($id, $item_data);  
        if (updated_item){
            $this->_updateListItems();        
        } else {
            $response = array (
                'status' => false, //http status
                'code' => 500, // error code
                'message' => 'Error', // string message
                'data' => null
            );
            header("Content-Type: application/json");
            http_response_code(500);
            echo json_encode($response);            
        }              
    }

    public function deleteItem()
    {
        $id = $_POST['id']; 
        $list_item = new listItem();
$deleted_item = $list_item->delete($id);   
        if ($deleted_item){
            $this->_updateListItems();        
        } else {
            $response = array (
                'status' => false, //http status
                'code' => 500, // error code
                'message' => 'Error', // string message
                'data' => null
            );
            header("Content-Type: application/json");
            http_response_code(500);
            echo json_encode($response);            
        }

    }

    private function _updateListItems($shopping_list_id)
    {
        if (!isset($_SESSION['loggedin'])) {
            header('Location: /');
            exit;
        } 
        $item = new listItem();
        $list_items = $item->get_by_list_id($shopping_list_id);
        $data = [];
        foreach($list_items as $index => $item) {
            $data[$item->id] = $item;
        }
        $result = array(
            'data' => $data
        );
        header("Content-Type: application/json");
        http_response_code(200);
        
        echo json_encode($result);

    }



}