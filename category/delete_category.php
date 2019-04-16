<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("todoList");
    session_start();
}
if(!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] !== true ){
    header('Location: /login.php');
    exit;
}
require $_SERVER['DOCUMENT_ROOT']."/requires/function.php";

$id_category = (isset($_POST["id_category"]) && !empty($_POST["id_category"])) ? $_POST["id_category"] : null;

if ($id_category){
    deleteCategory($id_category);
}

header("Location: list_category.php");
exit();