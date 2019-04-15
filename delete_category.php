<?php
require "./requires/function.php";

$id_category = (isset($_POST["id_category"]) && !empty($_POST["id_category"])) ? $_POST["id_category"] : null;

if ($id_category){
    deleteCategory($id_category);
}

header("Location: list_category.php");
exit();