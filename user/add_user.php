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
$title = 'Création';
require $_SERVER['DOCUMENT_ROOT']."/requires/function.php";
include $_SERVER['DOCUMENT_ROOT']."/includes/head.php";

$username = (isset($_POST["username"]) && !empty($_POST["username"]))? $_POST["username"] : null;
$email = (isset($_POST["email"]) && !empty($_POST["email"]))? $_POST["email"] : null;
$password = (isset($_POST["password"]) && !empty($_POST["password"]))? $_POST["password"] : null;


if( $_SERVER["REQUEST_METHOD"] == "POST" && $username && $email && $password){
    if(createUser($username, $email, $password)){
        header("Location: /user/list_user.php");
        exit();
    };
}
include $_SERVER['DOCUMENT_ROOT']."/includes/navbar.php";
?>
<div class="container">
    <div class="row mt-3">
        <h3 class="col-12 text-center">Créer un utilisateur</h3>
    </div>
    <div class="row justify-content-center">
        <div class="col-8 mt-5">
            <form action="<?= $_SERVER['PHP_SELF'];?>" method="post">
                <div class="form-group">
                    <label for="task">Username :</label>
                    <input type="text"
                           class="form-control"
                           id="username" name="username"
                           placeholder="Nom de l'utilisateur"
                           autocomplete="Off"
                           required />
                </div>
                <div class="form-group">
                    <label for="task">Email :</label>
                    <input type="email"
                           class="form-control"
                           id="email" name="email"
                           placeholder="Email"
                           autocomplete="Off"
                           required />
                </div>
                <div class="form-group">
                    <label for="task">Password :</label>
                    <input type="password"
                           class="form-control"
                           id="password" name="password"
                           placeholder="Mot de passe"
                           autocomplete="Off"
                           required />
                </div>
                <div class="form-group">
                    <a href="/user/list_user.php">
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
include $_SERVER['DOCUMENT_ROOT']."/includes/footer.php";

?>
