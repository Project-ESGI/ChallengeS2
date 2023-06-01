<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
		<script src="./js/main.js"></script>
    <script src="./js/JQuery 3.5.1.js"></script>

        <title>Accueil</title>
</head>
<body>
<?php include $this->header; ?>
<div class="container">
<h1>Bienvenue dans la nouvelle saison !</h1>
</div>
<?php include $this->footer; ?>
</body>
</html>
<script>
	document.getElementById('menu-button').addEventListener('click', function(e){
    document.getElementById('site-nav').classList.toggle('open');
})
</script>