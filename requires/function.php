<?php
require "config/DbPdo.php";

function getConnexion(){
    return DbPdo::pdoConnexion();
}

function getAllTodo($doneFilter = null){
    $todos = [];

    $filterString = '';
    if( isset($doneFilter) && !empty($doneFilter) ){
        $filterString = 'AND done = '.$doneFilter;
    }
    $con = getConnexion();
    $query = $con->prepare(
        "SELECT * FROM `todo` 
                INNER JOIN priority 
                WHERE `todo`.`priority` = `priority`.`id_priority` $filterString
                ORDER BY `done` ASC, 
                `priority`.`value` DESC");
    $query->execute();

    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        array_push($todos, $row);
    }


    return $todos;
}

function getAllCategories(){
    $categories = [];

    $con = getConnexion();
    $query = $con->prepare("SELECT * FROM `category`");
    $query->execute();

    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        array_push($categories, $row);
    }


    return $categories;
}

function getAllPriority(){
    $priorities = [];

    $con = getConnexion();
    $query = $con->prepare("SELECT * FROM `priority` ORDER BY `value` ASC");
    $query->execute();

    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        array_push($priorities, $row);
    }


    return $priorities;
}

function createTodo($task,$priority, $target_file = null){
    $con = getConnexion();
    $query = $con->prepare("INSERT INTO todo (`id`,`task`,`done`,`imgPath`,`priority`) VALUES (NULL, :task, false, :imgPath, :priority)");
    return $query->execute(array(':task'=>$task,':priority'=>$priority ,':imgPath'=> $target_file));
}

function createCategory($name){
    $con = getConnexion();
    $query = $con->prepare("INSERT INTO category (`id_category`,`name`) VALUES (NULL, :name)");
    return $query->execute(array(':name'=>$name));
}

function getTodoById($id){
    $con = getConnexion();
    $query = $con->prepare("SELECT * FROM todo WHERE id = :id");
    $query->execute(array(":id"=>$id));
    $todo = $query->fetch(PDO::FETCH_ASSOC);
    return $todo;
}

function getCategoryById($id_category){
    $con = getConnexion();
    $query = $con->prepare("SELECT * FROM category WHERE id_category = :id_category");
    $query->execute(array(":id_category"=>$id_category));
    $category = $query->fetch(PDO::FETCH_ASSOC);
    return $category;
}

function changeStateTodo($id, $state){
    $con = getConnexion();
    $query = $con->prepare("UPDATE todo SET `done`= :done WHERE `id`= :id");
    $result = $query->execute(array(":id"=>$id, ":done"=>$state));
    return $result;
}
function updateTodo($id, $task, $priority,$imgPath = null, $forceDelete = false){
    $con = getConnexion();
    $query = $con->prepare("UPDATE todo SET `task`= :task , `priority` = :priority WHERE `id`= :id");
    $params = array(":id"=>$id, ":task"=>$task, ":priority"=> $priority);
    if (!empty($imgPath) && !$forceDelete){
        $todo = getTodoById($id);
        if (!empty($todo['imgPath'])){
            deleteImg($todo['imgPath']);
        }
        $query = $con->prepare("UPDATE todo SET `task`= :task, `priority` = :priority , `imgPath`= :imgPath WHERE `id`= :id");
        $params[":imgPath"] = $imgPath;
    }
    if (empty($imgPath) && $forceDelete){
        $todo = getTodoById($id);
        if (!empty($todo['imgPath'])){
            deleteImg($todo['imgPath']);
        }
        $query = $con->prepare("UPDATE todo SET `task`= :task, `priority` = :priority , `imgPath`= :imgPath WHERE `id`= :id");
        $params[":imgPath"] = $imgPath;
    }

    $result = $query->execute($params);
    return $result;
}

function updateCategory($id_category, $name){
    $con = getConnexion();
    $query = $con->prepare("UPDATE category SET `name`= :nameCategory WHERE `id_category`= :id_category");
    $result = $query->execute(array(":nameCategory"=>$name, ":id_category"=>$id_category));
    return $result;
}

function deleteImg($path){
    if(file_exists($path)){
        unlink($path);
    }
}

function deleteTodo($id){
    $todo = getTodoById($id);
    if (!empty($todo['imgPath'])){
        deleteImg($todo['imgPath']);
    }
    $con = getConnexion();
    $query = $con->prepare("DELETE FROM todo WHERE id = :id");
    $query->execute(array(":id"=>$id));
}

function deleteCategory($id_category){
    $con = getConnexion();
    $query = $con->prepare("DELETE FROM category WHERE id_category = :id_category");
    $query->execute(array(":id_category"=>$id_category));
}
















