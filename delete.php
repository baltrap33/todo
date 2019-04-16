<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("todoList");
    session_start();
}
if(!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] !== true ){
    header('Location: /login.php');
    exit;
}
require "./requires/function.php";

$id = (isset($_POST["id"]) && !empty($_POST["id"])) ? $_POST["id"] : null;

if ($id){
    deleteTodo($id);
}

header("Location: index.php");
exit();