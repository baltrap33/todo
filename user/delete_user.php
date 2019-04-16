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

$id_user = (isset($_POST["id_user"]) && !empty($_POST["id_user"])) ? $_POST["id_user"] : null;

if ($id_user){
    deleteUser($id_user);
}

header("Location: /user/list_user.php");
exit();