<?php
require "./requires/function.php";

$page = 'edition de la catégorie';
include "./includes/head.php";

$id_category = (isset($_GET["id_category"]) && !empty($_GET["id_category"])) ? $_GET["id_category"] : null;

if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
    $id_category = (isset($_POST["id_category"]) && !empty($_POST["id_category"])) ? $_POST["id_category"] : null;
    $name = (isset($_POST["name"]) && !empty($_POST["name"])) ? $_POST["name"] : null;

    $updated = updateCategory($id_category, $name);
    if ($updated){
        header("Location: /list_category.php");
        exit();
    }
}

$category = getCategoryById($id_category);
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 mt-5">
                <form id="edit-form" action="<?= $_SERVER['PHP_SELF'];?>" method="post">
                    <input type="hidden" name="id_category" value="<?= $category['id_category'];?>" />
                    <div class="form-group">
                        <label for="task">Libellé</label>
                        <input type="text"
                               class="form-control"
                               id="name" name="name"
                               placeholder="catégorie"
                               value="<?= $category['name'];?>"
                               autocomplete="Off"
                               required />
                    </div>
                    <div class="form-group">
                        <a href="/list_category.php">
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
include "./includes/footer.php";

?>