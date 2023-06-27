function changeSvg() {

    if ($('header div button').attr("id") === "menu-button") {
        $('header div button').removeAttr('id');
        $('header div button').attr('id', 'cancel-button');

    } else {
        $('header div button').removeAttr('id');
        $('header div button').attr('id', 'menu-button');
    }
}

function toggleMenu() {
    document.getElementById('site-nav').classList.toggle('open');
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('menu-button').addEventListener('click', toggleMenu);
});