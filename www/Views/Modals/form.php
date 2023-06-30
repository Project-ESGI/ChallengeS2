<form class="d-flex flex-column align-items-center justify-content-center mt-4" method="<?= $config["config"]["method"] ?? "GET" ?>" action="<?= $config["config"]["action"] ?>">
    <?php foreach ($config["inputs"] as $name => $input): ?>
        <div class="form-group mb-3">
            <label for="<?= $name; ?>" class="text-white">
                <?= ucfirst($name); ?>:
            </label>

            <?php if ($input["type"] == "select"): ?>
                <select class="form-control" name="<?= $name; ?>">
                    <?php foreach ($input["options"] as $option): ?>
                        <option <?= ($option === ($input["value"] ?? null)) ? "selected" : "" ?>>
                            <?= $option; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            <?php else: ?>
                <input class="form-control" name="<?= $name; ?>" type="<?= $input["type"] ?>" placeholder="<?= $input["placeholder"] ?>" value="<?= isset($input["value"]) ? $input["value"] : '' ?>">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <input class="btn btn-primary mt-3" type="submit" name="submit" value="<?= $config["config"]["submit"] ?>">
</form>
