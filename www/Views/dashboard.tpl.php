<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="./images/soccerBallBlack.svg">
        <title>Accueil</title>
</head>
<body>
<?php include "Main/header.view.php"; ?>
<div class="container">
<h1>Bienvenue dans la nouvelle saison !</h1>
    <?php include $this->view; ?>
</div>
<?php include "Main/footer.view.php"; ?>
</body>
</html>