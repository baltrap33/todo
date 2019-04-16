<footer class="container-fluid navbar-dark bg-dark fixed-bottom">
    <div class="row">
        <div class="col-12 text-center navbar-text">@project 2019</div>
    </div>
</footer>
<?php
    foreach($scripts as $script){
        echo "<script src=\"../js/$script\"></script>";
    }
?>
</body>
</html>
