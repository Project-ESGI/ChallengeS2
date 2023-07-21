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
                    <h1 class="text-center">Étape 3 : Configuration du site</h1>
                </div>
                <div class="card-body">
                    <form action="login" method="post">
                        <div class="form-group">
                            <label for="site_name">Site name</label>
                            <input type="text" class="form-control" name="site_name" id="site_name" value="My site">
                        </div>
                        <div class="form-group">
                            <label for="table_prefix">Table prefix</label>
                            <input type="text" class="form-control" name="table_prefix" id="table_prefix" value="esgi_">
                        </div>
                        <div class="form-group">
                            <label for="admin_email">Admin email</label>
                            <input type="email" class="form-control" name="admin_email" id="admin_email" value="admin@admin.fr">
                        </div>
                        <div class="form-group">
                            <label for="admin_pass">Admin password</label>
                            <input type="password" class="form-control" name="admin_pass" id="admin_pass" value="">
                        </div>
                        <?php if (isset($_POST['db_host'])): ?>
                            <input type="hidden" name="db_host" value="<?= $_POST['db_host'] ?>">
                        <?php endif; ?>
                        <?php if (isset($_POST['db_name'])): ?>
                            <input type="hidden" name="db_name" value="<?= $_POST['db_name'] ?>">
                        <?php endif; ?>
                        <?php if (isset($_POST['db_user'])): ?>
                            <input type="hidden" name="db_user" value="<?= $_POST['db_user'] ?>">
                        <?php endif; ?>
                        <?php if (isset($_POST['db_pass'])): ?>
                            <input type="hidden" name="db_pass" value="<?= $_POST['db_pass'] ?>">
                        <?php endif; ?>
                        <?php if (isset($_POST['api_url'])): ?>
                            <input type="hidden" name="api_url" value="<?= $_POST['api_url'] ?>">
                        <?php endif; ?>
                        <button onclick="window.history.back();" type="button" class="btn btn-secondary">Précédent</button>
                        <?php if (isset($_POST['site_url'])): ?>
                            <input type="hidden" name="site_url" value="<?= $_POST['site_url'] ?>">
                        <?php endif; ?>
                        <input type="submit" value="Valider" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>
