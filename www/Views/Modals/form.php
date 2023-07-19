    <form class="text-left mx-auto card p-4 w-100 p-2"
          method="<?= $config["config"]["method"] ?? "GET" ?>" action="<?= $config["config"]["action"] ?>">
        <h1 class="h3 mb-3 text-center"><?php echo $config["config"]["titre"] ?></h1>

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
                <?php elseif ($input["type"] == "textarea"): ?>
                    <textarea class="form-control" name="<?= $name; ?>" type="<?= $input["type"] ?>"
                              placeholder="<?= $input["placeholder"] ?>"
                              rows="5"><?= isset($input["value"]) ? $input["value"] : '' ?></textarea>
                <?php else: ?>
                    <input class="form-control" name="<?= $name; ?>" type="<?= $input["type"] ?>"
                           placeholder="<?= $input["placeholder"] ?>"
                           value="<?= isset($input["value"]) ? $input["value"] : '' ?>">
                <?php endif; ?>
                <?php if (isset($config["config"]["errors"][$name])): ?>
                    <div class="text-danger error-message"><?= $config["config"]["errors"][$name] ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <input class="btn btn-lg btn-primary btn-block mt-3" type="submit" name="submit"
               value="<?= $config["config"]["submit"] ?>">

    </form>

    <p class="my-3 text-center">
        <a href="https://github.com/coliff/bootstrap-show-password-toggle" class="text-muted">
            &copy; 2023
        </a>
    </p>

