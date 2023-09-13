<body>
<form action="setupapi" method="post">
    <div class="container mt-5">
        <ul class="nav nav-tabs" id="myTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="etape1-tab" data-toggle="tab" role="tab"
                   aria-controls="etape1" aria-selected="true">Étape 1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="etape2-tab" data-toggle="tab" role="tab"
                   aria-controls="etape2" aria-selected="false">Étape 2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="etape3-tab" data-toggle="tab" role="tab"
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
                                    <div class="form-group">
                                        <label for="inputServer">Serveur</label>
                                        <input type="text" class="form-control" id="inputServer" name="db_server"
                                               placeholder="Nom ou adresse du serveur de la base de données" required>
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
                                               value="PostgreSQL" placeholder="Nom du système de la base de données" readonly disabled>
                                    </div>
                                    <div class="d-flex justify-content-end pt-3">
                                        <button type="submit" class="btn btn-primary" id="next-button-1">Suivant</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show" id="etape2-content" role="tabpanel" aria-labelledby="etape2-tab">
                <div class="container">
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-center">Étape 2 : Configuration de la connexion</h5>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="step" value="2">
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
                                    <div class="d-flex justify-content-between pt-3">
                                        <button type="button" class="btn btn-secondary" id="prev-button-2">Précédent
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="next-button-2">Suivant</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane show fade" id="etape3-content" role="tabpanel" aria-labelledby="etape3-tab">
                <div class="container">
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="text-center">Étape 3 : Configuration du site</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="admin_email">Identifiant de l'administrateur</label>
                                        <input type="email" class="form-control" name="admin_email" id="admin_email"
                                               value="admin@admin.fr">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin_pass">Mot de passe de l'administrateur</label>
                                        <input type="password" class="form-control" name="admin_pass" id="admin_pass"
                                               value="">
                                    </div>
                                    <div class="d-flex justify-content-between pt-3">
                                        <button type="button" class="btn btn-secondary" id="prev-button-3">Précédent
                                        </button>
                                        <button type="submit" class="btn btn-success" id="installer">Installer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>