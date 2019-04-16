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
require $_SERVER['DOCUMENT_ROOT']."/requires/function.php";
include $_SERVER['DOCUMENT_ROOT']."/includes/head.php";

$id_user = (isset($_GET["id_user"]) && !empty($_GET["id_user"])) ? $_GET["id_user"] : null;

if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
    $id_user = (isset($_POST["id_user"]) && !empty($_POST["id_user"])) ? $_POST["id_user"] : null;
    $username = (isset($_POST["username"]) && !empty($_POST["username"]))? $_POST["username"] : null;
    $email = (isset($_POST["email"]) && !empty($_POST["email"]))? $_POST["email"] : null;
    $password = (isset($_POST["password"]) && !empty($_POST["password"]))? $_POST["password"] : null;

    $updated = updateUser($id_user, $username, $email, $password);
    if ($updated){
        header("Location: /user/list_user.php");
        exit();
    }
}

$user = getUserById($id_user);
include $_SERVER['DOCUMENT_ROOT']."/includes/navbar.php";
?>
    <div class="container">
        <div class="row mt-3">
            <h3 class="col-12 text-center">Editer un utilisateur</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-8 mt-5">
                <form id="edit-form" action="<?= $_SERVER['PHP_SELF'];?>" method="post">
                    <input type="hidden" name="id_user" value="<?= $user['id_user'];?>" />
                    <div class="form-group">
                        <label for="task">Username :</label>
                        <input type="text"
                               class="form-control"
                               id="username" name="username"
                               placeholder="Nom de l'utilisateur"
                               value="<?= $user['username'];?>"
                               autocomplete="Off"
                               required />
                    </div>
                    <div class="form-group">
                        <label for="task">Email :</label>
                        <input type="email"
                               class="form-control"
                               id="email" name="email"
                               placeholder="Email"
                               value="<?= $user['email'];?>"
                               autocomplete="Off"
                               required />
                    </div>
                    <div class="form-group">
                        <label for="task">Password :</label>
                        <input type="password"
                               class="form-control"
                               id="password" name="password"
                               placeholder="Mot de passe"
                               autocomplete="Off" />
                    </div>
                    <div class="form-group">
                        <a href="/user/list_user.php">
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

$scripts = ["jquery.min.js", "popperjs.min.js", "bootstrap.min.js"];
include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php";

?>