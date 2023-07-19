<head>
    <meta charset="UTF-8">
    <title>Installation du site</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>

<?php
$envFilePath = '.env';
$exampleFilePath = '.env.example';

if (file_exists($envFilePath)) {
    $envContent = file_get_contents($envFilePath);
    $exampleContent = file_get_contents($exampleFilePath);

    $envLines = explode(PHP_EOL, $envContent);
    $exampleLines = explode(PHP_EOL, $exampleContent);

    $envKeys = array_map(function($line) {
        return substr($line, 0, strpos($line, '='));
    }, $envLines);

    $exampleKeys = array_map(function($line) {
        return substr($line, 0, strpos($line, '='));
    }, $exampleLines);

    $missingKeys = array_diff($exampleKeys, $envKeys);

    if (empty($missingKeys)) {
        echo 'Déjà installé';
        die();
    }
}

$step = isset($_POST['step']) ? $_POST['step'] : 1;

if ($step == 1) {
    echo '<h1>Étape 1 : Configuration de la base de données et test de connexion</h1>' . PHP_EOL;
    ?>
    <form action="" method="post">
        <input type="hidden" name="step" value="2">
        <label for="db_host">Hôte de la base de données</label>
        <input type="text" name="db_host" id="db_host" value="localhost">
        <label for="db_name">Nom de la base de données</label>
        <input type="text" name="db_name" id="db_name" value="test">
        <label for="db_user">Utilisateur de la base de données</label>
        <input type="text" name="db_user" id="db_user" value="root">
        <label for="db_pass">Mot de passe de la base de données</label>
        <input type="password" name="db_pass" id="db_pass" value="">
        <input type="button" value="Tester la connexion" disabled>
        <input type="submit" value="Suivant" disabled>
    </form>
    <script>
        const inputs = document.querySelectorAll('input');
        const submit = document.querySelector('input[type="submit"]');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const empty = Array.from(inputs).some(input => input.value === '');
                document.querySelector('input[type="button"]').disabled = empty;
                submit.disabled = true;
            });
        });

        const button = document.querySelector('input[type="button"]');
        button.addEventListener('click', () => {
            console.log('test');
            fetch('install/test.php', {
                method: 'post',
                body: new FormData(document.querySelector('form'))
            }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('input[type="submit"]').disabled = false;
                        button.disabled = true;
                        alert('Connexion réussie');
                    } else {
                        alert(data.message);
                    }
                })
        })
    </script>
    <?php
} elseif ($step == 2) {
    echo '<h1>Étape 2 : Configuration du site</h1>' . PHP_EOL;
    ?>
    <form action="" method="post">
        <input type="hidden" name="step" value="3">
        <label for="site_name">Nom du site</label>
        <input type="text" name="site_name" id="site_name" value="Mon site">
        <label for="table_prefix">Préfixe des tables</label>
        <input type="text" name="table_prefix" id="table_prefix" value="esgi_">
        <label for="admin_email">Email de l'administrateur</label>
        <input type="email" name="admin_email" id="admin_email" value="admin@admin.fr">
        <label for="admin_pass">Mot de passe de l'administrateur</label>
        <input type="password" name="admin_pass" id="admin_pass" value="">
        <input type="hidden" name="db_host" value="<?= $_POST['db_host'] ?>">
        <input type="hidden" name="db_name" value="<?= $_POST['db_name'] ?>">
        <input type="hidden" name="db_user" value="<?= $_POST['db_user'] ?>">
        <input type="hidden" name="db_pass" value="<?= $_POST['db_pass'] ?>">
        <input type="button" value="Configurer le site" disabled>
        <input type="button" value="Forcer la configuration du site" disabled>
        <input type="submit" value="Suivant" disabled>
    </form>
    <script>
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const empty = Array.from(inputs).some(input => input.value === '');
                document.querySelector('input[type="button"]').disabled = empty;
            });
        });

        const button = document.querySelectorAll('input[type="button"]')[0];
        const forceButton = document.querySelectorAll('input[type="button"]')[1];
        button.addEventListener('click', () => {
            fetch('install/setup.php', {
                method: 'post',
                body: new FormData(document.querySelector('form'))
            }).then(response => response.json()).then(data => {
                console.log(data);
                if (data.success) {
                    document.querySelector('input[type="submit"]').disabled = false;
                    button.disabled = true;
                    alert('Site configuré');
                } else {
                    alert(data.message);
                    forceButton.disabled = false;
                }
            })
        })
        forceButton.addEventListener('click', () => {
            var formData = new FormData(document.querySelector('form'));
            formData.append('force', true);
            fetch('install/setup.php', {
                method: 'post',
                body: formData
            }).then(response => response.json()).then(data => {
                console.log(data);
                if (data.success) {
                    document.querySelector('input[type="submit"]').disabled = false;
                    button.disabled = true;
                    alert('Site configuré');
                } else {
                    alert(data.message);
                }
            })
        })
    </script>
    <?php
} elseif ($step == 3) {
    echo 'Le site est installé ! Vous pouvez vous connecter à l\'administration avec l\'email et le mot de passe que vous avez renseignés.';
    echo '<a href="/login">Connexion</a>';
}
?>
