document.addEventListener("DOMContentLoaded", function () {
    document.querySelector('form').addEventListener('submit', function (event) {
        event.preventDefault();
        const email = document.querySelector('input[name="email"]').value;
        const password = document.querySelector('input[name="password"]').value;
        const digest = document.querySelector('input[name="digest"]').value;
        let pwd = SHA1(password);
        console.log(email + pwd + digest);
        let hash = SHA1(email + pwd + digest);
        let form = this;

        $.ajax({
            url: "/validate",
            type: 'POST',
            async: false,
            cache: false,
            data: {
                'email': email,
                'password': hash,
                'submit' : 1
            },
            success: function (response) {
                window.location.href = "/";
            },
            error: function (response) {
                let error = document.querySelector('input[name="password"]');
                let existDiv = form.getElementsByClassName('error');
                if(existDiv.length === 0) {
                    let div = document.createElement('div');
                    error.parentNode.insertBefore(div, error.nextSibling);
                    div.classList.add('error');
                    div.append('Email ou mot de passe incorrect !');
                }
                form.reset();
            }
        });
    });
});
