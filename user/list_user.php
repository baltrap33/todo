<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("todoList");
    session_start();
}
if(!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] !== true ){
    header('Location: /login.php');
    exit;
}

$page = 'user';
$title = 'Utilisateurs';
require $_SERVER['DOCUMENT_ROOT']."/requires/function.php";
include $_SERVER['DOCUMENT_ROOT']."/includes/head.php";

$users = getAllUsers();
include $_SERVER['DOCUMENT_ROOT']."/includes/navbar.php";
?>

    <div class="container">
        <div class="row mt-3">
            <h3 class="col-12 text-center">Liste des utilisateurs</h3>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">created_at</th>
                        <th scope="col">updated_at</th>
                        <th>
                            <a href="/user/add_user.php">
                                <button class="btn btn-sm btn-success float-right">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($users as $user) {
                        $user_date_created = $user["created_at"];
                        $user_date_updated = $user["updated_at"];
                        $dateCreated = new DateTime($user_date_created);
                        $dateUpdated = new DateTime($user_date_updated);
                        ?>
                        <tr id="user-row-id-<?= $user["id_user"]; ?>">
                            <th scope="row"><?= $user["id_user"]; ?></th>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $dateCreated->format('H:i d/m/Y'); ?></td>
                            <td><?= $dateUpdated->format('H:i d/m/Y'); ?></td>
                            <td class="row float-right mr-1">
                                <a href="/user/edit_user.php?id_user=<?= $user["id_user"]; ?>">
                                    <button class="btn btn-sm btn-info" type="button">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                                <?php $currentUser = $_SESSION["user"]; ?>
                                <form class="ml-2" action="/user/delete_user.php" method="post">
                                    <input type="hidden" name="id_user" value="<?= $user["id_user"]; ?>" />
                                    <button class="btn btn-sm btn-danger <?= ($user["id_user"] == $currentUser["id_user"])? "disabled":""; ?>"
                                        <?= ($user["id_user"] == $currentUser["id_user"])? "disabled":""; ?> type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<?php

$scripts = ["jquery.min.js", "popperjs.min.js", "bootstrap.min.js"];
include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php";

?>