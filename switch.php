<?php
require "./requires/function.php";

$id = (isset($_POST["id"]) && !empty($_POST["id"])) ? $_POST["id"] : null;
$state = (isset($_POST["state"])) ? $_POST["state"] : null;
$data = array( "updated" => "error");

if ($id){
    $result = changeStateTodo($id, ($state == 'true')? 1:0);
    $data["updated"] = $result?"success":"error";
}

header('Content-Type: application/json');
echo json_encode($data);
exit;