<?php
require "./requires/function.php";

$page = 'création';
include "./includes/head.php";

$task = (isset($_POST["task"]) && !empty($_POST["task"]))? $_POST["task"] : null;
$priority = (isset($_POST["priority"]) && !empty($_POST["priority"]))? $_POST["priority"] : null;
$file = (isset($_FILES["imgTodo"]["name"]) && !empty($_FILES["imgTodo"]["name"])) ? $_FILES["imgTodo"] : null;

$priorities = getAllPriority();

if( $_SERVER["REQUEST_METHOD"] == "POST" && $task){
    $target_file = null;
    if($file){
        $target_dir = "./uploads/";
        $imageFileType = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
        $imageFileName = strtolower(pathinfo($file["name"],PATHINFO_FILENAME));
        $time = time();
        $target_file = $target_dir . $imageFileName . "-" . $time .".". $imageFileType;
        move_uploaded_file($file["tmp_name"], $target_file);
    }
    if(createTodo($task, $priority, $target_file)){
        header("Location: index.php");
        exit();
    };
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8 mt-5">
            <form action="<?= $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="task">Libellé :</label>
                    <input type="text"
                           class="form-control"
                           id="task" name="task"
                           placeholder="tâche à faire"
                           required />
                </div>
                <div class="form-group">
                    <label for="priority">Priorité :</label>
                    <select class="form-control" id="priority" name="priority">
                        <?php foreach ($priorities as $priority) {?>
                            <option value="<?= $priority["id_priority"]; ?>"><?= $priority["name"]; ?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="task">Ajouter une image :</label>
                    <input type="file"
                           class="form-control-file"
                           id="imgTodo" name="imgTodo" />
                </div>
                <div class="form-group">
                    <a href="/index.php">
                        <button type="button" class="btn btn-sm btn-info">Annuler</button>
                    </a>
                    <button class="btn btn-sm btn-danger float-right" type="submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

$scripts = ["jquery.min.js", "popperjs.min.js", "bootstrap.min.js"];
include "./includes/footer.php";

?>
