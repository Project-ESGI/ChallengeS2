function changeSvg() {
    if ($('header div button').attr("id") === "menu-button") {
        $('header div button').removeAttr('id');
        $('header div button').attr('id', 'cancel-button');
    } else {
        $('header div button').removeAttr('id');
        $('header div button').attr('id', 'menu-button');
    }
}

function toggleDropdown() {
    var dropdown = document.querySelector('.dropdown-menu');
    dropdown.classList.toggle('show');
}

document.addEventListener('DOMContentLoaded', function() {
    var dropdownToggle = document.querySelector('.dropdown-toggle');
    dropdownToggle.addEventListener('click', toggleDropdown);
});

function toggleMenu() {
    document.getElementById('site-nav').classList.toggle('open');
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('menu-button').addEventListener('click', toggleMenu);
});

