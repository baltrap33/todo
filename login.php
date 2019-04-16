<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("todoList");
    session_start();
}
$page = 'login';
$title = 'Se connecter';
require "./requires/function.php";
include "./includes/head.php";

$email = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : '';
$password = (isset($_POST['password']) && !empty($_POST['password'])) ? $_POST['password'] : '';
$keepConnected = (isset($_POST['keepConnected']) && !empty($_POST['keepConnected'])) ? $_POST['keepConnected'] : false;
$deconnexion = (isset($_GET['deconnexion']) && !empty($_GET['deconnexion'])) ? $_GET['deconnexion'] : null;

if ($deconnexion == true && $_SESSION['isConnected'] === true) {
    session_destroy();
    header('Location: /index.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $logging = user_login($email, $password);
    if ($logging) {
        if ($_SESSION['isConnected'] !== true) {
            $_SESSION['isConnected'] = true;
            $_SESSION['timeStamp'] = time();
        }
    }
}

if (isset($_SESSION['isConnected']) && $_SESSION['isConnected'] === true) {
    header('Location: /index.php');
    exit;
}
include "./includes/navbar.php";
?>
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: -webkit-fill-available ;">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h4 class="card-title text-center"></h4>
                        <form class="form-signin" action="<?= $_SERVER['PHP_SELF']?>" method="post">
                            <?php
                            if (  isset($logging) && $logging === false ){ ?>
                                <div class="col alert alert-danger">
                                    Le couple identifiant / mot de passe n'existe pas.
                                </div>
                                <?php
                            }
                            ?>

                            <div class="form-label-group">
                                <input type="email" id="email" name="email"
                                       class="form-control"
                                       placeholder="Email" required autofocus>
                            </div>

                            <div class="form-label-group mt-3">
                                <input type="password" id="password" name="password"
                                       class="form-control"
                                       placeholder="Mot de passe" required>
                            </div>

                            <button class="btn btn-lg btn-primary btn-block text-uppercase mt-3"
                                    type="submit">Se connecter</button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
<?php

$scripts = ["jquery.min.js", "popperjs.min.js", "bootstrap.min.js", "toastr.min.js"];
include "./includes/footer.php";

?>