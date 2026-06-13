 let currentPhoto = 0;
    let zoomValue = 1;
    const lightbox = document.getElementById("photoLightbox");
    const lightboxImage = document.getElementById("lightboxImage");
    const lightboxCaption = document.getElementById("lightboxCaption");
    const lightboxDescription = document.getElementById("lightboxDescription");
    const lightboxCounter = document.getElementById("lightboxCounter");
    const thumbsStrip = document.getElementById("thumbsStrip");
    const lightboxBottom = document.getElementById("lightboxBottom");
    const lightboxBackdropGallery = document.getElementById("lightboxBackdropGallery");

    function openLightbox(index) {
        currentPhoto = index;
        zoomValue = 1;
        lightbox.classList.add("active");
        document.body.style.overflow = "hidden";
        buildThumbs();
        buildBackdropGallery();
        showPhoto();
    }

    function closeLightbox() {
        lightbox.classList.remove("active");
        document.body.style.overflow = "";
    }

    function showPhoto() {
        if (!photos.length) return;
        const photo = photos[currentPhoto];
        lightboxImage.src = photo.image;
        lightboxImage.alt = photo.title;
        lightboxImage.style.transform = "scale(" + zoomValue + ")";
        lightboxCaption.textContent = photo.title;
        lightboxDescription.textContent = photo.details;
        lightboxCounter.textContent = (currentPhoto + 1) + " / " + photos.length;
        document.querySelectorAll(".thumb-item").forEach((thumb, index) => {
            thumb.classList.toggle("active", index === currentPhoto);
        });
    }

    function nextPhoto() {
        currentPhoto = (currentPhoto + 1) % photos.length;
        zoomValue = 1;
        showPhoto();
    }

    function prevPhoto() {
        currentPhoto = (currentPhoto - 1 + photos.length) % photos.length;
        zoomValue = 1;
        showPhoto();
    }

    function zoomIn() {
        zoomValue += 0.2;
        if (zoomValue > 2.4) zoomValue = 2.4;
        showPhoto();
    }

    function zoomOut() {
        zoomValue -= 0.2;
        if (zoomValue < 1) zoomValue = 1;
        showPhoto();
    }

    function toggleThumbs() {
        lightboxBottom.style.display =
            lightboxBottom.style.display === "none" ? "flex" : "none";
    }

    function buildThumbs() {
        thumbsStrip.innerHTML = "";
        photos.forEach((photo, index) => {
            const item = document.createElement("div");
            item.className = "thumb-item";
            const img = document.createElement("img");
            img.src = photo.image;
            img.alt = photo.title;
            img.onerror = function() {
                this.src = "uploadsPhotos/default.png";
            };
            item.appendChild(img);
            item.onclick = () => {
                currentPhoto = index;
                zoomValue = 1;
                showPhoto();
            };
            thumbsStrip.appendChild(item);
        });
    }

    function buildBackdropGallery() {
        lightboxBackdropGallery.innerHTML = "";
        photos.forEach(photo => {
            const box = document.createElement("div");
            box.className = "lightbox-bg-item";
            const img = document.createElement("img");
            img.src = photo.image;
            img.alt = photo.title;
            img.onerror = function() {
                this.src = "uploadsPhotos/default.png";
            };
            box.appendChild(img);
            lightboxBackdropGallery.appendChild(box);
        });
    }
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".photo-card").forEach((card, index) => {
            setTimeout(() => {
                card.classList.add("show");
            }, index * 170);
        });
    });
    document.addEventListener("keydown", function(e) {
        if (!lightbox.classList.contains("active")) return;
        if (e.key === "Escape") closeLightbox();
        if (e.key === "ArrowLeft") nextPhoto();
        if (e.key === "ArrowRight") prevPhoto();
    });

    const videoModal = document.getElementById("videoModal");
    const popupVideo = document.getElementById("popupVideo");
    const videoTitle = document.getElementById("videoTitle");
    const videoDetails = document.getElementById("videoDetails");

    function openVideoModal(videoSrc, title, details) {
        videoModal.classList.add("active");
        popupVideo.src = videoSrc;
        popupVideo.load();
        popupVideo.play();
        videoTitle.textContent = title;
        videoDetails.textContent = details;
        document.body.style.overflow = "hidden";
    }

    function closeVideoModal() {
        videoModal.classList.remove("active");
        popupVideo.pause();
        popupVideo.src = "";
        document.body.style.overflow = "";
    }
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") {
            closeVideoModal();
        }
    });
