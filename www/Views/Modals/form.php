<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form class="d-flex flex-column align-items-center bg-primary rounded border border-primary p-4">
                <?php foreach ($config["inputs"] as $name => $input): ?>
                    <?php if ($input["type"] == "select"): ?>
                        <div class="form-group mb-3">
                            <label class="text-white"><?= $input["label"]; ?></label>
                            <select class="form-control" name="<?= $name; ?>">
                                <?php foreach ($input["options"] as $option): ?>
                                    <option><?= $option; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <div class="form-group mb-3">
                            <input class="form-control" name="<?= $name; ?>" type="<?= $input["type"]; ?>" placeholder="<?= $input["placeholder"]; ?>">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <button class="btn btn-primary btn-lg btn-block mt-4" type="submit" name="submit" style="background-color: #ff3366; border-color: #ff3366;"><?= $config["config"]["submit"]; ?></button>
            </form>
        </div>
    </div>
</div>
