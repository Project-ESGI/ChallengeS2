<head>
    <meta charset="UTF-8">
    <title>Installer le site</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>

<?php
/* if (!(!file_exists('.env') || filesize('.env') === 0)) {
echo 'Already installed';
die();
} */
//si le fichier .env existe et qu'il ne contient pas tout les paramètres du fichier .env.example
$envFilePath = '.env';
$exampleFilePath = '.env.example';

// Read the contents of the files
if (file_exists($envFilePath)){
    $envContent = file_get_contents($envFilePath);
    $exampleContent = file_get_contents($exampleFilePath);

// Convert the contents into arrays of lines
    $envLines = explode(PHP_EOL, $envContent);
    $exampleLines = explode(PHP_EOL, $exampleContent);

// Remove empty lines
    $envLines = array_filter($envLines);
    $exampleLines = array_filter($exampleLines);

// Extract the keys (lines before the equal sign)
    $envKeys = array_map(function($line) {
        return substr($line, 0, strpos($line, '='));
    }, $envLines);

    $exampleKeys = array_map(function($line) {
        return substr($line, 0, strpos($line, '='));
    }, $exampleLines);

// Check if the same keys are present
    $missingKeys = array_diff($exampleKeys, $envKeys);

    if(empty($missingKeys)) {
        echo 'Already installed';
        die();
    }
}

$step = isset($_POST['step']) ? $_POST['step'] : 1;

if ($step == 1) {
    echo '<h1>Step 1: Setup database and test connection</h1>' . PHP_EOL;
    ?>
    <form action="" method="post">
        <input type="hidden" name="step" value="2">
        <label for="db_host">Database host</label>
        <input type="text" name="db_host" id="db_host" value="localhost">
        <label for="db_name">Database name</label>
        <input type="text" name="db_name" id="db_name" value="test">
        <label for="db_user">Database user</label>
        <input type="text" name="db_user" id="db_user" value="root">
        <label for="db_pass">Database password</label>
        <input type="password" name="db_pass" id="db_pass" value="">
        <input type="button" value="Test connexion" disabled>
        <input type="submit" value="Next" disabled>
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
        button.addEventListener('click', () =>{
            console.log('test');
            //tester la connexion à la base de données
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
    echo '<h1>Step 2: Setup site</h1>' . PHP_EOL;
    ?>
    <form action="" method="post">
        <input type="hidden" name="step" value="3">
        <!-- demande le nom du site -->
        <label for="site_name">Site name</label>
        <input type="text" name="site_name" id="site_name" value="My site">
        <!-- demande le prefix des tables -->
        <label for="table_prefix">Table prefix</label>
        <input type="text" name="table_prefix" id="table_prefix" value="esgi_">
        <!-- demande le nom de l'admin -->
        <label for="admin_email">Admin email</label>
        <input type="email" name="admin_email" id="admin_email" value="admin@admin.fr">
        <!-- demande le mot de passe de l'admin -->
        <label for="admin_pass">Admin password</label>
        <input type="password" name="admin_pass" id="admin_pass" value="">
        <!-- hidden connection infomation -->
        <input type="hidden" name="db_host" value="<?= $_POST['db_host'] ?>">
        <input type="hidden" name="db_name" value="<?= $_POST['db_name'] ?>">
        <input type="hidden" name="db_user" value="<?= $_POST['db_user'] ?>">
        <input type="hidden" name="db_pass" value="<?= $_POST['db_pass'] ?>">
        <input type="button" value="Setup site" disabled>
        <input type="button" value="Force setup site" disabled>
        <input type="submit" value="Next" disabled>
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
        button.addEventListener('click', () =>{
            //setup le site
            fetch('install/setup.php', {
                method: 'post',
                body: new FormData(document.querySelector('form'))
            }).then(response => response.json()).then(data => {
                console.log(data);
                if (data.success) {
                    document.querySelector('input[type="submit"]').disabled = false;
                    button.disabled = true;
                    alert('Site setup');
                } else {
                    alert(data.message);
                    forceButton.disabled = false;

                }
            })
        })
        forceButton.addEventListener('click', () =>{
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
                    alert('Site setup');
                } else {
                    alert(data.message);
                }
            })
        })
    </script>
    <?php
} elseif ($step == 3) {
    echo 'Le site est installé ! Vous pouvez vous connecter à l\'administration avec l\'email et le mot de passe que vous avez renseigné';
    echo '<a href="/login">Connexion</a>';
}