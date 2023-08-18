document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get("action");
    const entity = urlParams.get("entity");
    const type = urlParams.get("type");
    const id = urlParams.get("id");
    const pageName = window.location.pathname.substring(window.location.pathname.lastIndexOf("/") + 1);
    let location;

    switch (action) {
        case "add":
            alert(`${entity} créé avec succès !`);
            location = pageName;
            break;
        case "edit":
            alert(`${entity} modifié avec succès !`);
            location = pageName;
            break;
        case "delete":
            alert(`${entity} supprimé avec succès !`);
            location = pageName;
            break;
        case "existreported":
            alert(`Commentaire déjà signalé !`);
            location = pageName;
            break;
    }

    if (location) {
        window.location.href = location;
    }
})
;
