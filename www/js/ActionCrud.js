document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get("action");
    const entity = urlParams.get("entity");
    const type = urlParams.get("type");
    const pageName = window.location.pathname.substring(window.location.pathname.lastIndexOf("/") + 1);
    let location;

    switch (action) {
        case "created":
            alert(`${pageName} créé avec succès !`);
            location = pageName;
            break;
        case "updated":
            alert(`${pageName} modifié avec succès !`);
            location = pageName;
            break;
        case "deleted":
            alert(`${pageName} supprimé avec succès !`);
            location = pageName;
            break;
        case "reported":
            alert(`Commentaire signalé avec succès !`);
            location = pageName;
            break;
        case "existreported":
            alert(`Commentaire déjà signalé !`);
            location = pageName;
            break;
        case "empty":
            alert(`L\'${entity} doit avoir un ${type} !`);
            location = pageName;
            break;
        case "doublon":
            alert(`Un ${entity} avec ce ${type} existe déjà !`);
            location = pageName;
            break;
    }

    if (location) {
        window.location.href = location;
    }
})
;
