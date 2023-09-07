import bcrypt from "immutable";

document.addEventListener("DOMContentLoaded", function (value) {
    document.querySelector('form').addEventListener('submit', function (event) {
        event.preventDefault();
        const email = document.querySelector('input[name="email"]').value;
        const password = document.querySelector('input[name="password"]').value;

        const saltRounds = 10; // Adjust the number of rounds as needed
        bcrypt.hash(password, saltRounds, function (err, hash) {
            if (err) {
                console.error(err);
                return;
            }

            document.querySelector('#digest').value = hash;
            // Submit the form
            this.submit();
        });
    });
});