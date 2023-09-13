document.addEventListener("DOMContentLoaded", function () {
    const nextButton1 = document.getElementById("next-button-1");
    const prevButton2 = document.getElementById("prev-button-2");
    const nextButton2 = document.getElementById("next-button-2");
    const prevButton3 = document.getElementById("prev-button-3");
    const installButton = document.getElementById("installer");
    const stepTabs = document.querySelectorAll(".nav-link");

    let currentStep = 1;

    const formDataStep1 = {};

    function showStep(step) {
        document.getElementById(`etape${currentStep}-content`).classList.remove("show", "active");
        document.getElementById(`etape${step}-content`).classList.add("show", "active");

        // Mettre à jour l'onglet actif
        stepTabs[currentStep - 1].classList.remove("active");
        stepTabs[step - 1].classList.add("active");

        currentStep = step;
    }

    function isStep1Valid() {
        const inputServer = document.getElementById("inputServer").value;
        const inputPort = document.getElementById("inputPort").value;
        const inputDatabase = document.getElementById("inputDatabase").value;
        const inputSystem = document.getElementById("inputSystem").value;

        // Stocker les données du premier formulaire
        formDataStep1.server = inputServer;
        formDataStep1.port = inputPort;
        formDataStep1.database = inputDatabase;
        formDataStep1.system = inputSystem;

        return inputServer !== "" && inputPort !== "" && inputDatabase !== "" && inputSystem !== "";
    }

    function isStep2Valid() {
        const inputUser = document.getElementById("inputDbUser").value;
        const inputPassword = document.getElementById("inputDbPassword").value;

        return inputUser !== "" && inputPassword !== "";
    }

    nextButton1.addEventListener("click", function (event) {
        event.preventDefault();
        if (isStep1Valid()) {
            showStep(2);
        } else {
            let existDiv = document.querySelector('form').getElementsByClassName('error');
            if (existDiv.length === 0) {
                let error = document.querySelector('div.card-body');
                let div = document.createElement('div');
                div.classList.add('error');
                div.textContent = 'Tous les champs doivent être remplis !';

                // Insérer la nouvelle div en avant-dernière position
                let children = error.children;
                if (children.length >= 2) {
                    error.insertBefore(div, children[children.length - 1]);
                } else {
                    error.appendChild(div);
                }

                setTimeout(function() {
                    div.remove();
                }, Math.floor(Math.random() * 2000) + 3000);
            }
        }
    });

    prevButton2.addEventListener("click", function () {
        showStep(1);
    });

    nextButton2.addEventListener("click", function (event) {
        event.preventDefault();
        if (isStep2Valid()) {
            showStep(3);
        }
    });

    prevButton3.addEventListener("click", function () {
        showStep(2);
    });
});
