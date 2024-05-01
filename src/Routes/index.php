<?php

use App\Controllers\UserController;
use App\Controllers\ShoppingListController;
use App\Controllers\ListItemController;
use App\Router;

$router = new Router();

$router->get('/', UserController::class, 'index');

$router->post('/signup', UserController::class, 'signup');
$router->post('/login', UserController::class, 'login');

$router->get('/lists', ShoppingListController::class, 'index');
$router->post('/user-lists', ShoppingListController::class, 'getUserLists');


$router->post('/list/create', ShoppingListController::class, 'createList');
$router->post('/list/edit', ShoppingListController::class, 'editList');
$router->post('/list/delete', ShoppingListController::class, 'deleteList');

$router->get('/list-items', ListItemController::class, 'index');
$router->post('/list-items', ListItemController::class, 'getListItems');

$router->post('/item/create', ListItemController::class, 'createItem');
$router->post('/item/edit', ListItemController::class, 'editItem');
$router->post('/item/delete', ListItemController::class, 'deleteItem');


$router->dispatch();