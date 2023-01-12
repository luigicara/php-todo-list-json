<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: X-Requested-With");

header('Content-Type: application/json');

$index = intval($_GET['taskStatus']);

$jsonTodoList = file_get_contents("todo.json", true);
$todoList = json_decode($jsonTodoList, true);

if ($todoList[$index]["completed"] == true) {

    $todoList[$index]["completed"] = false;

} elseif ($todoList[$index]["completed"] == false) {
    
    $todoList[$index]["completed"] = true;

}

$jsonTodoList = json_encode($todoList);
file_put_contents('todo.json', $jsonTodoList);