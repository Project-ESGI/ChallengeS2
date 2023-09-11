document.addEventListener("DOMContentLoaded", function () {
    document.querySelector('form').addEventListener('submit', function (event) {
        event.preventDefault();
        const email = document.querySelector('input[name="email"]').value;
        const password = document.querySelector('input[name="password"]').value;
        const digest = document.querySelector('input[name="digest"]').value;
        let pwd = SHA1(password);
        let hash = SHA1(email + pwd + digest);
        let form = this;

        $.ajax({
            url: "/",
            type: 'POST',
            async: false,
            cache: false,
            data: {
                'email': email,
                'password': hash
            },
            success: function (response) {
                // document.querySelector('form').submit();
                form.submit();
            }
        });
    });
});
