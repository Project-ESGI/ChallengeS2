<form class="d-flex justify-content-center"
      method="<?= $config["config"]["method"] ?? "GET" ?>"
      action="<?= $config["config"]["action"] ?>">

    <?php foreach ($config["inputs"] as $name => $input): ?>

        <?php if ($input["type"] == "select"): ?>
            <select name="<?= $name; ?>">
                <?php foreach ($input["options"] as $option): ?>
                    <option><?= $option; ?></option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <input
                    name="<?= $name; ?>"
                    type="<?= $input["type"] ?>"
                    placeholder=" <?= $input["placeholder"] ?>"
                    value="<?= isset($input["value"]) ? $input["value"] : '' ?>"
            >
        <?php endif; ?>

    <?php endforeach; ?>

    <input type="submit" name="submit" value="<?= $config["config"]["submit"] ?>">
</form>