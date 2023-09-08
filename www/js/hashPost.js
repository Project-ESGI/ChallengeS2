document.addEventListener("DOMContentLoaded", function (value) {
    document.querySelector('form').addEventListener('submit', function (event) {
        event.preventDefault();
        const email = document.querySelector('input[name="email"]').value;
        const password = document.querySelector('input[name="password"]').value;
        const digest = document.querySelector('input[name="digest"]').value;

        const saltRounds = 10; // Adjust the number of rounds as needed
        let pwd = SHA1(password);
        let hash = SHA1(email+pwd+digest);
        console.log(hash);

        /*, function (err, hash) {
            if (err) {
                console.error(err);
                return;
            }

            document.querySelector('#digest').value = hash;
            // Submit the form
            this.submit();
        });
        */
            $.ajax({
                url: "/",
                type: 'POST',
                async: false,
                cache: false,
                data: {
                    'email': email,
                    'password': hash
                },
                success: function (login_salt) {
                    console.log(email);
                    console.log(password);
                    // password = $.sha1($('#password').val());
                    // $('#password').val("");
                    // $('#password_hash').val($.sha1(login_salt + password));
                }
            });

    });
});