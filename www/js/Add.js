document.addEventListener("DOMContentLoaded", function() {
    var openModalBtn = document.querySelector(".openModalBtn");
    var closeModalBtn = document.querySelector(".closeModalBtn");
    var modal = document.querySelector(".myModal");

    openModalBtn.addEventListener("click", function() {
        modal.style.display = "block";
    });

    closeModalBtn.addEventListener("click", function() {
        modal.style.display = "none";
    });

    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
