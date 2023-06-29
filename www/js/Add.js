document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get("action");

    switch (action) {
        case "created":
            alert("Page créée avec succès");
            break;
        case "updated":
            alert("Page modifiée avec succès");
            break;
        case "deleted":
            alert("Page supprimée avec succès");
            break;
    }

});
