<form class="text-left mx-auto card p-4 w-100 p-2"
      method="<?= $config["config"]["method"] ?? "GET" ?>" action="<?= $config["config"]["action"] ?>">
    <h1 class="h3 mb-3 text-center"><?php echo $config["config"]["titre"] ?></h1>

    <?php foreach ($config["inputs"] as $name => $input): ?>
        <div class="mb-3">
            <label for="<?= $name; ?>" class="form-label"><?= ucfirst($name); ?>:</label>
            <?php if ($input["type"] == "select"): ?>
                <select class="form-select" id="<?= $name ?>" name="<?= $name; ?>">
                    <?php foreach ($input["options"] as $option): ?>
                        <option <?= ($option === ($input["value"] ?? null)) ? "selected" : "" ?>>
                            <?= $option; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php elseif ($input["type"] == "textarea"): ?>
                <textarea class="form-control" name="<?= $name; ?>" id="<?= $name ?>" type="<?= $input["type"] ?>"
                          placeholder="<?= $input["placeholder"] ?>"
                          rows="5"><?= isset($input["value"]) ? $input["value"] : '' ?></textarea>
            <?php else: ?>
                <input class="form-control" id="<?= $name ?>" name="<?= $name; ?>" type="<?= $input["type"] ?>"
                       placeholder="<?= $input["placeholder"] ?>"
                       value="<?= isset($input["value"]) ? $input["value"] : '' ?>">
            <?php endif; ?>
            <?php if (isset($config["config"]["errors"][$name])): ?>
                <div class="text-danger error-message"><?= $config["config"]["errors"][$name] ?></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <input type="hidden" id="slugInput" name="slugInput">

    <input class="btn btn-lg btn-primary btn-block mt-3" type="submit" name="submit"
           value="<?= $config["config"]["submit"] ?>">

</form>

<?php if (isset($config["config"]["ckeditor"])): ?>
    <script src="./ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.config.language = 'fr';
        CKEDITOR.replace('content');
    </script>
<?php endif; ?>

<script>
    const slugify = str => str.toLowerCase().trim().replace(/[^\w\s-]/g, "").replace(/[\s_-]+/g, "-").replace(/^-+|-+$/g, "");

    // Écouteur d'événement pour détecter les modifications du champ de saisie du slug
    const slugInput = document.getElementById("slug");
    const slugInputHidden = document.getElementById("slugInput");

    slugInput.addEventListener("input", function() {
        const slug = slugify(this.value);
        slugInputHidden.value = slug; // Stocke l'URL générée dans le champ de formulaire "slugInput"
    });
</script>

