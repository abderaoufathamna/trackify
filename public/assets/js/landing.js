// Navbar & Back to Top logic on Scroll
const nav = document.getElementById("navbar");
const backToTop = document.getElementById("backToTop");

window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
        nav.classList.add("scrolled");
    } else {
        nav.classList.remove("scrolled");
    }

    if (window.scrollY > 300) {
        backToTop.classList.add("visible");
    } else {
        backToTop.classList.remove("visible");
    }
});

// Reveal Animation (Intersection Observer)
const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px"
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add("active");
        }
    });
}, observerOptions);

document.querySelectorAll(".reveal").forEach(el => {
    observer.observe(el);
});

// Active Link Highlighting on Scroll
const sections = document.querySelectorAll("section");
const navLinks = document.querySelectorAll(".nav-links a");

window.addEventListener("scroll", () => {
    let current = "";
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= sectionTop - sectionHeight / 3) {
            current = section.getAttribute("id");
        }
    });

    navLinks.forEach(link => {
        link.classList.remove("active");
        if (link.getAttribute("href") === "#" + current) {
            link.classList.add("active");
        }
    });
});

// Typewriter Effect
const textElement = document.getElementById('txt-animate');
const text = "Track Attendance Like a Pro";
let index = 0;
let isDeleting = false;
let speed = 100;

function type() {
    const currentText = text.substring(0, index);
    textElement.innerHTML = currentText + "<span class='cursor'>|</span>";

    if (!isDeleting) {
        index++;
        if (index > text.length) {
            isDeleting = true;
            speed = 2000;
        } else {
            speed = 100;
        }
    } else {
        index--;
        if (index < 1) {
            index = 1;
            isDeleting = false;
            speed = 500;
        } else {
            speed = 50;
        }
    }

    setTimeout(type, speed);
}

window.onload = () => {
    const style = document.createElement('style');
    style.innerHTML = `
        .cursor { font-weight: 300; color: rgba(255,255,255,0.7); animation: blink 1s infinite; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
    `;
    document.head.appendChild(style);

    type();
};
