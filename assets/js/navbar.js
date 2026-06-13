const toggler = document.querySelector(".navbar-toggler");
const menu = document.querySelector(".navbar-collapse");
const overlay = document.getElementById("menuOverlay");

if (toggler && menu && overlay) {
    toggler.addEventListener("click", function () {
        menu.classList.toggle("show");
        overlay.classList.toggle("active");
    });

    overlay.addEventListener("click", function () {
        menu.classList.remove("show");
        overlay.classList.remove("active");
    });

    document.querySelectorAll(".mobile-menu-list .nav-link").forEach(link => {
        link.addEventListener("click", function () {
            if (!this.classList.contains("dropdown-toggle")) {
                menu.classList.remove("show");
                overlay.classList.remove("active");
            }
        });
    });
}