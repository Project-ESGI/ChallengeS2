<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10"> <!-- Utilisez la classe col-md-8 pour définir la largeur de la div -->
            <?php print_r($errors??null);?>
            <?php $this->modal("form", $form );?>
        </div>
    </div>
</div>


<div class="container text-center mt-4">
    <p class="text-white">Vous avez déjà un compte ? <a href="/login">Connectez-vous</a> ici.</p>
</div>

<form class="d-flex justify-content-center mt-4" method="<?= $config["config"]["method"] ?? "GET" ?>"
      action="<?= $config["config"]["action"] ?>">
    <?php if (isset($config["inputs"]) && is_array($config["inputs"])): ?>
        <?php foreach ($config["inputs"] as $name => $input): ?>
            <div class="form-group">
                <label for="<?= $name; ?>" class="text-white">
                    <?= ucfirst($name); ?>:
                </label>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</form>
