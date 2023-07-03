<?php if ($user_pseudo !== null) : ?>
    <script src="../../js/Main.js"></script>
    <header>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-2">
                    <button id="menu-button" onclick="changeSvg('-')"></button>
                </div>
                <div class="col-4">
                    <a href="">
                        <img class="rotate-image" src="./images/soccerBall.svg" width="200px" alt="MC">
                    </a>
                </div>
                <div class="col-6">
                    <nav id="site-nav">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="./accueil">ACCUEIL</a>
                            </li>
                            <?php if ($user_role === 'admin') : ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="./user">UTILISATEURS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./article">PAGES</a>
                                </li>
                            <?php endif ?>
                            <li class="nav-item">
                                <a class="nav-link" href=""><?php echo $user_pseudo ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-primary" href="/logout">Déconnexion</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div id="sidebar" class="bg-light"></div>
<?php endif; ?>
