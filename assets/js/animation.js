// custom-alert 

setTimeout(() => {
    const alert = document.querySelector('.custom-alert');
    if (alert) {
        alert.style.transition = "0.5s";
        alert.style.opacity = "0";
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);

// counter
 const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-target');
        let count = 0;
        const updateCount = () => {
            const increment = target / 50;
            if (count < target) {
                count += increment;
                counter.innerText = Math.floor(count);
                setTimeout(updateCount, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });

// show
document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll(".cards-grid");
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add("show");
                setTimeout(() => {
                    card.style.transform += " scale(1.05)";
                    setTimeout(() => {
                        card.style.transform = "translateY(0) scale(1)";
                    }, 150);
                }, 400);

            }, index * 180);
        });
    });
// Stoires icon
  document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll(".story-icon-card");
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add("show");
                setTimeout(() => {
                    card.style.transform += " scale(1.05)";
                    setTimeout(() => {
                        card.style.transform = "translateY(0) scale(1)";
                    }, 150);
                }, 400);

            }, index * 180);
        });
    });

document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll(".story-card");
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.classList.add("show");
            }, index * 220);
        });
    });
// videos card
    document.addEventListener("DOMContentLoaded", function() {
        const videoCards = document.querySelectorAll(".video-card");
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add("show-video");
                    }, index * 150);

                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });
        videoCards.forEach(card => {
            observer.observe(card);
        });
    });
