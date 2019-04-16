<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">TodoList</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
                <li class="nav-item <?= $page === "dashboard"? "active":""; ?>">
                    <a class="nav-link" href="/index.php">Dashboard</a>
                </li>
            <?php if ( $logged ) { ?>
                <li class="nav-item">
                    <a class="nav-link" ></a>
                </li>
                <li class="nav-item dropdown <?= $page === "category"? "active":""; ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Gestion des catégories
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/list_category.php">Lister les catégories</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/add_category.php">Ajouter une catégorie</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/login.php?deconnexion=true">Déconnexion</a>
                </li>
            <?php } else { ?>
                <li class="nav-item <?= $page === "login"? "active":""; ?>">
                    <a class="nav-link" href="/login.php">Connexion</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
