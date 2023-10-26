function toggleMenu() {
    var menu = document.getElementById("navbar-menu");
    if (menu.className === "navbar-menu") {
        menu.className += " responsive";
    } else {
        menu.className = "navbar-menu";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    var footer = document.querySelector("footer");
    window.addEventListener("scroll", function() {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            footer.style.display = "block";
        } else {
            footer.style.display = "none";
        }
    });
});