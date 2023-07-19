<?php if ($user_pseudo !== null) : ?>
    <script src="./js/JQuery 3.5.1.js"></script>
    <script src="../../js/Main.js"></script>
    <script src="../../js/Menu.js"></script>
    <header>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-2">
                    <button id="menu-button" onclick="changeSvg('-')"></button>
                </div>
                <div class="col-4">
                    <a href="./accueil">
                        <img class="rotate-image" src="./images/soccerBall.svg" width="200px" alt="MC">
                    </a>
                </div>
                <div class="col-6">
                    <nav id="site-nav">
                        <ul class="nav flex-nowrap">
                            <li class="nav-item">
                                <a class="nav-link" href="./accueil">ACCUEIL</a>
                            </li>
                            <?php if ($user_role === 'admin') : ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="./comment">COMMENTAIRES</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./user">UTILISATEURS</a>
                                </li>
                            <?php endif ?>
                            <li class="nav-item">
                                    <a class="nav-link" href="./article">ARTICLES</a>
                                </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $user_pseudo ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="/logout">Déconnexion</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div id="sidebar" class="bg-light"></div>
<?php endif; ?>
