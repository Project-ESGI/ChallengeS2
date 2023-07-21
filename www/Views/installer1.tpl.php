<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Installer: Étape 1</title>
    <script src="./js/installer.js"></script>
</head>

<body>
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
                            <label for="inputDatabase">Base de données</label>
                            <input type="text" class="form-control" id="inputDatabase" name="db_name" placeholder="Nom de la base de données">
                        </div>
                        <div class="form-group">
                            <label for="inputUsername">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="inputUsername" name="db_user" placeholder="Nom de l'utilisateur de la base de données">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Mot de passe</label>
                            <input type="password" class="form-control" id="inputPassword" name="db_pass" placeholder="Mot de passe de la base de données">
                        </div>
                        <button type="submit" class="btn btn-primary">Installer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
