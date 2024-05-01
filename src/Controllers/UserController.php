<?php
namespace App\Controllers;
session_start();
use App\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $this->render('index');
    }

    public function signup()
    {
        $user_data = array(
            'name' => htmlspecialchars(trim($_POST['name'])),
            'email' => htmlspecialchars(trim($_POST['email'])),
            'password' => md5(htmlspecialchars(trim($_POST['password'])))
        );
        $user = new User();
        $inserted_user = $user->save($user_data);
        if ($inserted_user) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $user_data['name'];
            $_SESSION['id'] = $inserted_user;
            setcookie('session_id', session_id() , time()+3600 );
            header('Location: /lists');

        }
        
    }

    public function login()
    {
        $user_login_data = array(
            'email' => $_POST['email'],
            'password' => md5($_POST['password'])
        );

        $user = new User();
        $user = $user->get_by_login_data($user_login_data);
        
        if ($user) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $user->name;
            $_SESSION['id'] = $user->id;
            setcookie('session_id', session_id() , time()+3600 );
            header('Location: /lists');
        }
    }    
}