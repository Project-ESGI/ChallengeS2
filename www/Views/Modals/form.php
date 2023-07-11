<div class="<?php if ($config["config"]["typeArticle"] === "Créer") : ?>form-ajouter-article
<?php elseif ($config["config"]["typeArticle"] === "Modifier") : ?>form-modifier-article
<?php elseif ($config["config"]["typeUser"] === "Créer") : ?>form-ajouter-user
<?php elseif ($config["config"]["typeUser"] === "Modifier") : ?>form-modifier-user
<?php endif; ?>

form-container border d-flex align-items-center justify-content-center">
    <form class="d-flex flex-column align-items-center justify-content-center mt-4"
          method="<?= $config["config"]["method"] ?? "GET" ?>" action="<?= $config["config"]["action"] ?>">
        <?php foreach ($config["inputs"] as $name => $input): ?>
            <div class="mb-3">
                <label for="<?= $name; ?>" class="form-label"><?= ucfirst($name); ?>:</label>

                <?php if ($input["type"] == "select"): ?>
                    <select class="form-select" name="<?= $name; ?>">
                        <?php foreach ($input["options"] as $option): ?>
                            <option <?= ($option === ($input["value"] ?? null)) ? "selected" : "" ?>>
                                <?= $option; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <input class="form-control" name="<?= $name; ?>" type="<?= $input["type"] ?>"
                           placeholder="<?= $input["placeholder"] ?>"
                           value="<?= isset($input["value"]) ? $input["value"] : '' ?>">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <input class="btn btn-primary btn-custom mt-3" type="submit" name="submit"
               value="<?= $config["config"]["submit"] ?>">
    </form>
</div>
