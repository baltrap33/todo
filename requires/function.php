<?php
require $_SERVER['DOCUMENT_ROOT']."/config/DbPdo.php";

$logged = false;
if ( isset($_SESSION['isConnected']) && $_SESSION['isConnected'] === true ) {
    $logged = true;
}

function getConnexion(){
    return DbPdo::pdoConnexion();
}

function user_login($email, $password){
    $con = getConnexion();
    $query = $con->prepare("SELECT * FROM `user` WHERE email= :email and password= :password;");
    $query->execute(array(':email' => $email, ':password' => sha1($password)));
    $count = $query->rowCount();
    if($count == 1){
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if (session_status() == PHP_SESSION_NONE) {
                session_name("todoList");
                session_start([
                    'cookie_lifetime' => 86400,
                ]);
            }
            $_SESSION["user"] = $row;
        }
    }
    return $count == 1;
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
        $id_todo = $row["id"];
        $row["categories"] = getCategoriesByTodo($id_todo);
        array_push($todos, $row);
    }


    return $todos;
}

function getCategoriesByTodo($id_todo){
    $todoCategories = [];
    $con = getConnexion();
    $query = $con->prepare(
            "SELECT * FROM todo_category 
                                INNER JOIN category 
                    WHERE todo_category.id_category = category.id_category 
                    AND  id_todo = :id_todo");
    $query->execute(array(":id_todo"=>$id_todo));
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        array_push($todoCategories, $row);
    }

    return $todoCategories;
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

function associateTodoCategories($id_todo, $id_category){
    $con = getConnexion();
    $query = $con->prepare(
                "INSERT INTO todo_category (`id_todo_category`, `id_todo`, `id_category`)
                VALUES (NULL, :id_todo, :id_category)");
    $query->execute(array(":id_todo"=>$id_todo, ":id_category"=>$id_category));
}

function deleteTodoCategoriesByTodo($id_todo){
    $con = getConnexion();
    $query = $con->prepare("DELETE FROM todo_category WHERE id_todo = :id_todo");
    $query->execute(array(":id_todo"=>$id_todo));
}

function deleteTodoCategoriesByCategory($id_category){
    $con = getConnexion();
    $query = $con->prepare("DELETE FROM todo_category WHERE id_category = :id_category");
    $query->execute(array(":id_category"=>$id_category));
}

function createTodo($task, $priority, $todoCategories, $target_file = null){
    $con = getConnexion();
    $query = $con->prepare(
                "INSERT INTO todo (`id`,`task`,`done`,`imgPath`,`priority`) 
                VALUES (NULL, :task, false, :imgPath, :priority)");
    $result = $query->execute(array(':task'=>$task,':priority'=>$priority ,':imgPath'=> $target_file));
    $id_todo = $con->lastInsertId();
    foreach ($todoCategories as $id_category){
        associateTodoCategories( $id_todo, $id_category);
    }
    return $result;
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
    $todo["categories"] = getCategoriesByTodo($id);
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
function updateTodo($id, $task, $priority, $todoCategories, $imgPath = null, $forceDelete = false){
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
    if ($result == true){
        deleteTodoCategoriesByTodo($id);
        foreach ($todoCategories as $id_category){
            associateTodoCategories( $id, $id_category);
        }
    }
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
    deleteTodoCategoriesByTodo($id);
}

function deleteCategory($id_category){
    $con = getConnexion();
    $query = $con->prepare("DELETE FROM category WHERE id_category = :id_category");
    $query->execute(array(":id_category"=>$id_category));
    deleteTodoCategoriesByCategory($id_category);
}

function getAllUsers(){
    $users = [];

    $con = getConnexion();
    $query = $con->prepare("SELECT * FROM `user`");
    $query->execute();

    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        array_push($users, $row);
    }


    return $users;
}

function createUser($username, $email, $password){
    $con = getConnexion();
    $query = $con->prepare(
        "INSERT INTO user (`id_user`,`username`,`email`,`password`) 
                    VALUES (NULL, :username, :email, :password)");
    return $query->execute(array(':username'=>$username, ':email'=>$email, ':password'=>sha1($password)));
}

function getUserById($id_user){
    $con = getConnexion();
    $query = $con->prepare("SELECT * FROM user WHERE id_user = :id_user");
    $query->execute(array(":id_user"=>$id_user));
    $user = $query->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function updateUser($id_user, $username, $email, $password = null){
    $con = getConnexion();
    $params = array(":id_user"=>$id_user, ":username"=>$username, ":email"=>$email);
    if (isset($password) && !empty($password)){
        $params[":password"] = sha1($password);
        var_dump($params);
        $query = $con->prepare(
            "UPDATE user SET `username`= :username, `email`= :email , `password`= :password
                    WHERE `id_user`= :id_user");

    }else{
        $query = $con->prepare(
            "UPDATE user SET `username`= :username, `email`= :email 
                    WHERE `id_user`= :id_user");
    }
    $result = $query->execute($params);
    return $result;
}

function deleteUser($id_user){
    $con = getConnexion();
    $query = $con->prepare("DELETE FROM user WHERE id_user = :id_user");
    $query->execute(array(":id_user"=>$id_user));
}














