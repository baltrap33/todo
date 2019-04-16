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

$name = (isset($_POST["name"]) && !empty($_POST["name"]))? $_POST["name"] : null;


if( $_SERVER["REQUEST_METHOD"] == "POST" && $name){
    if(createCategory($name)){
        header("Location: /category/list_category.php");
        exit();
    };
}
include $_SERVER['DOCUMENT_ROOT']."/includes/navbar.php";
?>
<div class="container">
    <div class="row mt-3">
        <h3 class="col-12 text-center">Créer une catégorie</h3>
    </div>
    <div class="row justify-content-center">
        <div class="col-8 mt-5">
            <form action="<?= $_SERVER['PHP_SELF'];?>" method="post">
                <div class="form-group">
                    <label for="task">Name :</label>
                    <input type="text"
                           class="form-control"
                           id="name" name="name"
                           placeholder="nom de la catégorie"
                           autocomplete="Off"
                           required />
                </div>
                <div class="form-group">
                    <a href="/category/list_category.php">
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
