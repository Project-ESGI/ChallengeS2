document.addEventListener("DOMContentLoaded", function () {
    function switchTab(tabId) {
        var tabs = document.querySelectorAll('.nav-link');
        tabs.forEach(function (tab) {
            tab.classList.remove('active');
        });

        var tabContent = document.querySelectorAll('.tab-pane');
        tabContent.forEach(function (tab) {
            tab.style.display = 'none';
        });

        document.querySelector('#' + tabId + '-tab').classList.add('active');
        document.querySelector('#' + tabId + '-content').style.display = 'block';
    }

    // Ajouter des écouteurs d'événements aux onglets
    document.querySelector('#etape1-tab').addEventListener('click', function (e) {
        e.preventDefault(); // Empêche la navigation par défaut du lien
        switchTab('etape1');
    });

    document.querySelector('#etape2-tab').addEventListener('click', function (e) {
        e.preventDefault(); // Empêche la navigation par défaut du lien
        switchTab('etape2');
    });

    document.querySelector('#etape3-tab').addEventListener('click', function (e) {
        e.preventDefault(); // Empêche la navigation par défaut du lien
        switchTab('etape3');
    });

    // Définir l'onglet actif au chargement de la page
    switchTab('etape1');
});
