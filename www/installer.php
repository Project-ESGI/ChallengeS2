<?php

namespace App;

use App\Core\View;

$step = isset($_POST['step']) ? $_POST['step'] : 1;

if ($step == 1) {
    $view = new View("Auth/installer", "installer1");
    ?>

    <script>
        const inputs = document.querySelectorAll('input');
        const submit = document.querySelector('input[type="submit"]');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const empty = Array.from(inputs).some(input => input.value === '');
                document.querySelector('input[type="button"]').disabled = empty;
                submit.disabled = true;
            });
        });

    </script>
    <?php
} elseif ($step == 2) {
    new View("Auth/installer", "installer2");
    ?>


    <script>
        const urlApi = document.querySelector('input[name="url_api"]');
        let url
        urlApi.addEventListener('input', () => {
            url = urlApi.value;
        })
    </script>
    <?php
} elseif ($step == 3) {
    new View("Auth/installer", "installer3"); ?>

    <script>
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const empty = Array.from(inputs).some(input => input.value === '');
                document.querySelector('input[type="button"]').disabled = empty;
            });
        });
    </script>
    <?php
}