<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="jumbotron">
                <h1 class="display-4 text-center"><?= $articleData['title'] ?></h1>
                <div class="lead text-left">
                    <?php
                    // Convertir les sauts de ligne en balises <br>
                    $contentLines = explode(PHP_EOL, $articleData['content']);
                    foreach ($contentLines as $line) {
                        echo nl2br($line);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
