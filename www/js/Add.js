document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get("action");

    switch (action) {
        case "created":
            alert("Article créée avec succès");
            window.location.href = "page";
            break;
        case "updated":
            alert("Article modifiée avec succès");
            window.location.href = "page";
            break;
        case "deleted":
            alert("Article supprimée avec succès");
            window.location.href = "page";
            break;
    }

});
