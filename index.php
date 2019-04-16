<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("todoList");
    session_start();
}
$page = 'dashboard';
$title = 'DashBoard';
require $_SERVER['DOCUMENT_ROOT']."/requires/function.php";
include $_SERVER['DOCUMENT_ROOT']."/includes/head.php";

$doneFilter = (isset($_GET["doneFilter"]) && !empty($_GET["doneFilter"]))? $_GET["doneFilter"] : null;
$todos = getAllTodo($doneFilter);

include $_SERVER['DOCUMENT_ROOT']."/includes/navbar.php";
?>

    <div class="container">
        <div class="row mt-3">
            <h3 class="col-12 text-center">Dashboard</h3>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <form class="input-group mb-3" method="get" action="<?= $_SERVER["PHP_SELF"];?>">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Afficher</span>
                    </div>
                    <select class="form-control" id="doneFilter" name="doneFilter">
                        <option value="" <?= $doneFilter == null ? "selected":"" ?>>toutes les tâches</option>
                        <option value="false" <?= $doneFilter == 'false' ? "selected":"" ?>>les tâches à faire</option>
                        <option value="true" <?= $doneFilter == 'true'? "selected":"" ?>>les tâches réalisées</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col">Task</th>
                        <th scope="col">Done</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>

                        <?php if ( $logged ) {?>
                        <th>
                            <a href="/add.php">
                                <button class="btn btn-sm btn-success float-right">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </a>
                        </th>
                        <?php } ?>

                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($todos) == 0){ ?>
                        <tr><td colspan="100" class="alert alert-info text-center">Aucune tâche</td></tr>
                    <?php }
                    foreach ($todos as $todo) {
                        $task_date_created = $todo["created_at"];
                        $task_date_updated = $todo["updated_at"];
                        $dateCreated = new DateTime($task_date_created);
                        $dateUpdated = new DateTime($task_date_updated);
                    ?>
                        <tr id="todo-row-id-<?= $todo["id"]; ?>">
                            <th scope="row"><?= $todo["id"]; ?></th>
                            <td style="max-width: 120px;"><img <?=
                                !empty($todo["imgPath"]) ?
                                    'src="'.$todo["imgPath"].'"' :
                                    'src="./images/default.jpg"' ; ?>
                                class="img-thumbnail" /></td>
                            <td><?= $todo["task"]; ?></td>
                            <td>
                                <label class="switch">
                                    <input class="input-checked" data-value="<?= $todo["id"]; ?>"
                                           type="checkbox" <?= ($todo["done"] == 0)? "":"checked"; ?>
                                            <?= $logged ? '':'disabled'?>
                                    >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td><?= $todo['name'] ?></td>
                            <td><?= $dateCreated->format('H:i d/m/Y'); ?></td>
                            <td class="todo-updated-at"><?= $dateUpdated->format('H:i d/m/Y'); ?></td>
                        <?php if ( $logged ) {?>
                            <td class="row">

                                <a href="/edit.php?id=<?= $todo["id"]; ?>">
                                    <button class="btn btn-sm btn-info" type="button">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>

                                <form class="ml-2" action="/delete.php" method="post">
                                    <input type="hidden" name="id" value="<?= $todo["id"]; ?>" />
                                    <button class="btn btn-sm btn-danger" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        <?php } ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<?php

$scripts = ["jquery.min.js", "popperjs.min.js", "bootstrap.min.js", "toastr.min.js"];
if ( $logged ) {
    array_push($scripts, "script-index.js");
}
include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php";

?>