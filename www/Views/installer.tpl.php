<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="./js/installer.js"></script>
    <title>Installer: Étape 1</title>
</head>

<body>
<div class="container mt-5">
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="etape1-tab" data-toggle="tab" href="#etape1-content" role="tab"
               aria-controls="etape1" aria-selected="true">Étape 1</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="etape2-tab" data-toggle="tab" href="#etape2-content" role="tab"
               aria-controls="etape2" aria-selected="false">Étape 2</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="etape3-tab" data-toggle="tab" href="#etape3-content" role="tab"
               aria-controls="etape3" aria-selected="false">Étape 3</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabsContent">
        <div class="tab-pane fade show active" id="etape1-content" role="tabpanel" aria-labelledby="etape1-tab">
            <div class="container">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Étape 1 : Installation de l'application</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="setupapi">
                                    <div class="form-group">
                                        <label for="inputServer">Serveur</label>
                                        <input type="text" class="form-control" id="inputServer" name="db_server"
                                               placeholder="Nom ou adresse du serveur de la base de données">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPort">Port</label>
                                        <input type="text" class="form-control" id="inputPort" name="db_port"
                                               placeholder="Numéro du port de la base de données">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDatabase">Base de données</label>
                                        <input type="text" class="form-control" id="inputDatabase" name="db_name"
                                               placeholder="Nom de la base de données">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSystem">Système</label>
                                        <input type="text" class="form-control" id="inputSystem" name="db_system"
                                               placeholder="Nom du système de la base de données">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Installer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="etape2-content" role="tabpanel" aria-labelledby="etape2-tab">
            <div class="container">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="text-center">Étape 2 : Configuration de l'URL de l'API</h1>
                            </div>
                            <div class="card-body">
                                <form action="site" method="post">
                                    <input type="hidden" name="step" value="3">
                                    <div class="form-group">
                                        <label for="url_api">URL de l'API (Ajouter le port)</label>
                                        <input type="text" class="form-control" name="url_api" id="url_api"
                                               value="<?= $_SERVER['HTTP_ORIGIN'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDbUser">Nom d'utilisateur de la base de données</label>
                                        <input type="text" class="form-control" id="inputDbUser" name="db_user"
                                               placeholder="Nom de l'utilisateur de la base de données">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDbPassword">Mot de passe de la base de données</label>
                                        <input type="password" class="form-control" id="inputDbPassword" name="db_pass"
                                               placeholder="Mot de passe de la base de données">
                                    </div>
                                    <button type="submit" class="btn btn-success">Next</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="etape3-content" role="tabpanel" aria-labelledby="etape3-tab">
            <div class="container">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="text-center">Étape 3 : Configuration du site</h1>
                            </div>
                            <div class="card-body">
                                <form action="login" method="post">
                                    <div class="form-group">
                                        <label for="site_name">Nom du site</label>
                                        <input type="text" class="form-control" name="site_name" id="site_name"
                                               value="My site">
                                    </div>
                                    <div class="form-group">
                                        <label for="table_prefix">Préfixe de table</label>
                                        <input type="text" class="form-control" name="table_prefix" id="table_prefix"
                                               value="esgi_">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_email">Email de l'administrateur</label>
                                        <input type="email" class="form-control" name="admin_email" id="admin_email"
                                               value="admin@admin.fr">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_pass">Mot de passe de l'administrateur</label>
                                        <input type="password" class="form-control" name="admin_pass" id="admin_pass"
                                               value="">
                                    </div>
                                    <button type="submit" class="btn btn-success">Valider</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
