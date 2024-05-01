<?php
namespace App\Controllers;
session_start();
use App\Controller;
use App\Models\ShoppingList;

class ShoppingListController extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['loggedin'])) {
            header('Location: /');
            exit;
        } else {
            $this->render('lists');
        }
    }

    public function getUserLists()
    {
        if (!isset($_SESSION['loggedin'])) {
            header('Location: /');
            exit;
        } 
        $list = new ShoppingList();
        $user_lists = $list->get_by_user_id($_SESSION['id']);
        $data = [];
        foreach($user_lists as $index => $list) {
            $data[$list->id] = $list;
            unset($list);
        }
        $result = array(
            'data' => $data
        );
        header("Content-Type: application/json");
        http_response_code(200);
        
        echo json_encode($result);

    }

  
    public function createList()
    {
        $list_data = array(
            'title' => htmlspecialchars(trim($_POST['title'])),
            'description' => htmlspecialchars(trim($_POST['description']))
        );
        $user_id = $_SESSION['id'];
        $shopping_list = new shoppingList();
        $inserted_list = $shopping_list->save($user_id, $list_data);
        $list_data['id'] = $inserted_list;
        if ($inserted_list) {
            $this->_updateUserLists();
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


    public function editList()
    {
        $list_data = array(
            'title' => $_POST['title'],
            'description' => $_POST['description']
        );
        $id = (int) $_POST['id']; 
        $shopping_list = new shoppingList();
        $updated_list = $shopping_list->update($id, $list_data);  
        if (updated_list){
            $this->_updateUserLists();        
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

    public function deleteList()
    {
        $id = $_POST['id']; 
        $shopping_list = new shoppingList();
        $deleted_list = $shopping_list->delete($id);   
        if ($deleted_list){
            $this->_updateUserLists();        
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

    private function _updateUserLists()
    {
        if (!isset($_SESSION['loggedin'])) {
            header('Location: /');
            exit;
        } 
        $list = new ShoppingList();
        $user_lists = $list->get_by_user_id($_SESSION['id']);
        $data = [];
        foreach($user_lists as $index => $list) {
            $data[$list->id] = $list;
            unset($list);
        }
        $result = array(
            'data' => $data
        );
        header("Content-Type: application/json");
        http_response_code(200);
        
        echo json_encode($result);

    }



}