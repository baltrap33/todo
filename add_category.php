<?php
require "./requires/function.php";

$page = 'création d\'une catégorie';
include "./includes/head.php";

$name = (isset($_POST["name"]) && !empty($_POST["name"]))? $_POST["name"] : null;


if( $_SERVER["REQUEST_METHOD"] == "POST" && $name){
    if(createCategory($name)){
        header("Location: list_category.php");
        exit();
    };
}
?>
<div class="container">
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
                    <a href="/list_category.php">
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
