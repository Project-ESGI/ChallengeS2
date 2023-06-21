$(document).ready(function() {
    $('#ajouterBtn').click(function() {
        // Appel à la fonction PHP pour ajouter une page
        $.ajax({
            url: '../Views/dashboard.tpl.php',
            type: 'POST',
            success: function(response) {
                alert('Page ajoutée avec succès !');
            },
            error: function() {
                alert('Erreur lors de l\'ajout de la page.');
            }
        });
    });
});