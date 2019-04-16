<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("todoList");
    session_start();
}
if(!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] !== true ){
    header('Location: /login.php');
    exit;
}
$page = '';
$title = 'Edition';
require "./requires/function.php";
include "./includes/head.php";

$id = (isset($_GET["id"]) && !empty($_GET["id"])) ? $_GET["id"] : null;

if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
    $id = (isset($_POST["id"]) && !empty($_POST["id"])) ? $_POST["id"] : null;
    $file = (isset($_FILES["imgTodo"]["name"]) && !empty($_FILES["imgTodo"]["name"])) ? $_FILES["imgTodo"] : null;
    $task = (isset($_POST["task"]) && !empty($_POST["task"])) ? $_POST["task"] : null;
    $priority = (isset($_POST["priority"]) && !empty($_POST["priority"])) ? $_POST["priority"] : null;
    $delete = (isset($_POST["delete"]) && !empty($_POST["delete"])) ? $_POST["delete"] : null;

    $target_file = null;
    if($file){
        $target_dir = "./uploads/";
        $imageFileType = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
        $imageFileName = strtolower(pathinfo($file["name"],PATHINFO_FILENAME));
        $time = time();
        $target_file = $target_dir . $imageFileName . "-" . $time .".". $imageFileType;
        move_uploaded_file($file["tmp_name"], $target_file);
    }

    $updated = updateTodo($id, $task,$priority, $target_file, boolval($delete));
    if ($updated){
        header("Location: /index.php");
        exit();
    }
}

$priorities = getAllPriority();
$todo = getTodoById($id);
include "./includes/navbar.php";
?>
    <div class="container">
        <div class="row mt-3">
            <h3 class="col-12 text-center">Editer une tâche</h3>
        </div>
        <div class="row justify-content-center">
            <?php
                if(isset($todo["imgPath"]) && !empty($todo["imgPath"])) {
                    ?>
                    <div class="col-8 text-center">
                        <div class="text-left">Image actuelle</div>
                        <img id="current-img" class="img-fluid" src="<?= $todo["imgPath"]; ?>"/>
                        <div id="img-btn-group" style="display: flex;justify-content: space-between;width: 100%;position: relative;top: -30px;">
                            <button type="button" class="btn btn-sm btn-danger" id="btn-delete-img">
                                <i class="fas fa-trash"></i></button>
                            <button type="button" class="btn btn-sm btn-info float-right" id="btn-change-img">
                                <i class="fas fa-edit"></i></button>
                        </div>
                    </div>
                    <?php
                }
            ?>
            <div class="col-8 mt-5">
                <form id="edit-form" action="<?= $_SERVER['PHP_SELF'];?>" method="post">
                    <input type="hidden" name="id" value="<?= $todo['id'];?>" />
                    <div class="form-group">
                        <label for="task">Libellé</label>
                        <input type="text"
                               class="form-control"
                               id="task" name="task"
                               placeholder="tâche à faire"
                               value="<?= $todo['task'];?>"
                               autocomplete="Off"
                               required />
                    </div>
                    <div class="form-group">
                        <label for="priority">Priorité :</label>
                        <select class="form-control" id="priority" name="priority">
                            <?php foreach ($priorities as $priority) {?>
                                <option value="<?= $priority["id_priority"]; ?>"
                                        <?= ($priority["id_priority"] == $todo["priority"])? "selected":"" ; ?>
                                ><?= $priority["name"]; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group <?= (isset($todo["imgPath"]) && !empty($todo["imgPath"]))? 'd-none':''; ?>" id="add-img-btn">
                        <button type="button" class="btn btn-sm btn-success" id="btn-add-img">
                            <i class="fas fa-image mr-2"></i>Associer une image ?
                        </button>
                    </div>
                    <div class="form-group" id="file-group-container"></div>
                    <div class="form-group">
                        <a href="/index.php">
                            <button type="button" class="btn btn-sm btn-info">
                                <i class="fas fa-ban mr-2"></i>Annuler
                            </button>
                        </a>
                        <button class="btn btn-sm btn-danger float-right" type="submit">
                            <i class="fas fa-save mr-2"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php

$scripts = ["jquery.min.js", "popperjs.min.js", "bootstrap.min.js", "script-edit.js"];
include "./includes/footer.php";

?>