<form class="d-flex justify-content-center"
      method="<?= $config["config"]["method"] ?? "GET" ?>"
      action="<?= $config["config"]["action"] ?>">

    <?php foreach ($config["inputs"] as $name => $input): ?>
        <label for="<?= $name; ?>">
            <?= ucfirst($name); ?>:
        </label>

        <?php if ($input["type"] == "select"): ?>
            <select name="<?= $name; ?>">
                <?php foreach ($input["options"] as $option): ?>
                    <option <?= ($option === $input["value"]) ? "selected" : "" ?>>
                        <?= $option; ?>
                    </option>
                <?php endforeach; ?>
            </select>

        <?php else: ?>
            <input
                    name="<?= $name; ?>"
                    type="<?= $input["type"] ?>"
                    placeholder="<?= $input["placeholder"] ?>"
                    value="<?= isset($input["value"]) ? $input["value"] : '' ?>"
            >
        <?php endif; ?>

    <?php endforeach; ?>

    <input type="submit" name="submit" value="<?= $config["config"]["submit"] ?>">
</form>
