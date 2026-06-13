let currentVideo = 0;
const videoLightbox = document.getElementById("videoLightbox");
const lightboxVideo = document.getElementById("lightboxVideo");
const lightboxCounter = document.getElementById("lightboxCounter");
const thumbsStrip = document.getElementById("thumbsStrip");
const lightboxCaption = document.getElementById("lightboxVideoCaption");
const lightboxDetails = document.getElementById("lightboxVideoDetails");
const videoModal = document.getElementById("videoModal");
const popupVideo = document.getElementById("popupVideo");
const videoTitle = document.getElementById("videoTitle");
const videoDetails = document.getElementById("videoDetails");
function openLightbox(index) {
    currentVideo = parseInt(index, 10);
    if (videoLightbox) {
        videoLightbox.classList.add("active");
        document.body.style.overflow = "hidden";
        buildThumbs();
        showVideo();
    }
}

function closeLightbox() {
    if (videoLightbox) {
        videoLightbox.classList.remove("active");
        document.body.style.overflow = "";
        if (lightboxVideo) {
            lightboxVideo.pause();
            lightboxVideo.src = "";
        }
    }
}

function showVideo() {
    if (typeof videos === 'undefined' || !videos.length) return;

    const videoData = videos[currentVideo];

    if (lightboxVideo) {
        lightboxVideo.poster = videoData.poster;
        lightboxVideo.src = videoData.video;
        lightboxVideo.load();
        lightboxVideo.play().catch(err => console.log("التشغيل التلقائي ينتظر تفاعل المستخدم:", err));
    }
    if (lightboxCaption) lightboxCaption.textContent = videoData.title;
    if (lightboxDetails) lightboxDetails.textContent = videoData.details;
    if (lightboxCounter) lightboxCounter.textContent = (currentVideo + 1) + " / " + videos.length;
    document.querySelectorAll(".thumb-item").forEach((thumb) => {
        const thumbIdx = parseInt(thumb.getAttribute("data-video-index"), 10);
        thumb.classList.toggle("active", thumbIdx === currentVideo);
    });
}

function nextVideo() {
    if (typeof videos === 'undefined' || !videos.length) return;
    currentVideo = (currentVideo + 1) % videos.length;
    showVideo();
}

function prevVideo() {
    if (typeof videos === 'undefined' || !videos.length) return;
    currentVideo = (currentVideo - 1 + videos.length) % videos.length;
    showVideo();
}
function buildThumbs() {
    if (!thumbsStrip || typeof videos === 'undefined' || !videos.length) return;
    thumbsStrip.innerHTML = "";
    videos.forEach((videoData, index) => {
        const item = document.createElement("div");
        item.className = "thumb-item";
        item.setAttribute("data-video-index", index);
        const img = document.createElement("img");
        img.src = videoData.poster;
        img.style.width = "100%";
        img.style.height = "100%";
        img.style.objectFit = "cover";
        img.style.pointerEvents = "none"; 
        const icon = document.createElement("div");
        icon.className = "thumb-play";
        icon.innerHTML = '<i class="bi bi-play-fill"></i>';
        icon.style.pointerEvents = "none"; 

        item.appendChild(img);
        item.appendChild(icon);
        item.addEventListener("click", function(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation(); 
            }
            currentVideo = index;
            showVideo();
        });

        thumbsStrip.appendChild(item);
    });
}

if (videoLightbox) {
    videoLightbox.addEventListener("click", function(e) {
        if (e.target === videoLightbox || e.target.classList.contains("lightbox-view")) {
            closeLightbox();
        }
    });
}
const prevBtn = document.querySelector(".lightbox-prev");
const nextBtn = document.querySelector(".lightbox-next");

if (prevBtn) {
    prevBtn.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();
        prevVideo();
    });
}

if (nextBtn) {
    nextBtn.addEventListener("click", function(e) {
        e.preventDefault();
        e.stopPropagation();
        nextVideo();
    });
}
document.addEventListener("keydown", function(e) {
    if (!videoLightbox || !videoLightbox.classList.contains("active")) return;
    if (e.key === "Escape") closeLightbox();
    if (e.key === "ArrowLeft") nextVideo();
    if (e.key === "ArrowRight") prevVideo();
});

function openVideoModal(videoSrc, title, details) {
    if (videoModal) {
        videoModal.classList.add("active");
        popupVideo.src = videoSrc;
        popupVideo.load();
        popupVideo.play();
        videoTitle.textContent = title;
        videoDetails.textContent = details;
        document.body.style.overflow = "hidden";
    }
}

function closeVideoModal() {
    if (videoModal) {
        videoModal.classList.remove("active");
        popupVideo.pause();
        popupVideo.src = "";
        document.body.style.overflow = "";
    }
}