
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php print_r($errors ?? null); ?>

            <?php $this->modal("form", $form); ?>
        </div>
    </div>
</div>

<div class="container text-center mt-4">
    <p class="text-white">Vous avez oublier votre mot de passe? <a href="/reset"> Reinitialiser votre mot de passe< /a> maintenant !</p>
</div>

<form class="d-flex flex-column justify-content-center mt-4" method="<?= $config["config"]["method"] ?? "GET" ?>"
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