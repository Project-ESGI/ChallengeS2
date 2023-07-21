<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Installer: Étape 2</title>
    <script src="./js/installer.js"></script>
</head>

<body>
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
                        <input type="text" name="site_url" id="site_url" value="<?= $_SERVER['HTTP_ORIGIN'] ?>" hidden>
                        <div class="form-group">
                            <label for="url_api">URL de l'API (Ajouter le port)</label>
                            <input type="text" class="form-control" name="url_api" id="url_api" value="<?= $_SERVER['HTTP_ORIGIN'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Avant de continuer, vérifiez les informations suivantes :</label>
                        </div>

                        <div class="text-center">
                            <!-- Bouton Précédent -->
                            <button onclick="window.history.back();" type="button" class="btn btn-secondary">Précédent</button>

                            <!-- Bouton Next -->
                            <input type="submit" class="btn btn-success" value="Next">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>