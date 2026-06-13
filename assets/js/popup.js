    const popup = document.getElementById("imagePopup");
    const popupImg = document.getElementById("popupImg");
    const images = document.querySelectorAll(".popup-image");
    const closeBtn = document.querySelector(".close-popup");
    images.forEach(img => {
        img.addEventListener("click", () => {
            popup.style.display = "flex";
            popupImg.src = img.src;
        });
    });
    closeBtn.addEventListener("click", () => {
        popup.style.display = "none";
    });
    popup.addEventListener("click", (e) => {
        if (e.target === popup) {
            popup.style.display = "none";
        }
    });
    const teamPopup = document.getElementById("teamImagePopup");
    const teamPopupImg = document.getElementById("teamPopupImg");
    const teamImages = document.querySelectorAll(".team-popup-image");
    const closeTeamPopup = document.getElementById("closeTeamPopup");
    teamImages.forEach(img => {
        img.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            teamPopup.style.display = "flex";
            teamPopupImg.src = img.src;
        });
    });
    closeTeamPopup.addEventListener("click", () => {
        teamPopup.style.display = "none";
    });
    teamPopup.addEventListener("click", (e) => {
        if (e.target === teamPopup) {
            teamPopup.style.display = "none";
        }
    });

