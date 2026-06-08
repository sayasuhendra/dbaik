import './bootstrap';
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import GLightbox from 'glightbox';

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

// Expose to window for global access
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.ScrollToPlugin = ScrollToPlugin;
window.GLightbox = GLightbox;

const initGlobalAnimations = () => {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    // --- SMOOTH SCROLL ---
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#' || !href) return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                gsap.to(window, {
                    duration: 1.2,
                    scrollTo: { y: target, offsetY: 80 },
                    ease: "power3.inOut"
                });
            }
        });
    });

    // --- BACK TO TO ---
    const btt = document.getElementById("back-to-top");
    if (btt) {
        ScrollTrigger.create({
            trigger: "body",
            start: "top -500px",
            onEnter: () => btt.classList.add("visible"),
            onLeaveBack: () => btt.classList.remove("visible")
        });

        btt.onclick = () => {
            gsap.to(window, {
                duration: 1.5,
                scrollTo: { y: 0 },
                ease: "power4.inOut"
            });
        };
    }

    // --- MOBILE NAV ---
    const burger = document.getElementById("burger-toggle");
    const mobileNav = document.getElementById("mobile-nav");
    const mobileClose = document.getElementById("mobile-nav-close");
    const mobileLinks = document.querySelectorAll(".mobile-link");

    if (burger && mobileNav) {
        const toggleMenu = () => {
            const isOpen = mobileNav.classList.toggle("open");
            burger.setAttribute("aria-expanded", isOpen);
            burger.classList.toggle("open", isOpen);
            if (isOpen) {
                gsap.fromTo(".mobile-nav a",
                    { y: 30, opacity: 0 },
                    { y: 0, opacity: 1, stagger: 0.08, duration: 0.5, ease: "back.out(1.4)", delay: 0.15 }
                );
            }
        };
        burger.onclick = toggleMenu;
        mobileLinks.forEach(link => link.onclick = () => {
            mobileNav.classList.remove("open");
            burger.classList.remove("open");
            burger.setAttribute("aria-expanded", "false");
        });
    }

    // --- SCROLL PROGRESS & REVEALS ---
    gsap.to("#progress-bar", {
        scaleX: 1,
        ease: "none",
        scrollTrigger: {
            trigger: "body",
            start: "top top",
            end: "bottom bottom",
            scrub: true
        }
    });

    ScrollTrigger.create({
        trigger: "body",
        start: "top -80px",
        onEnter: () => document.getElementById("navbar")?.classList.add("scrolled"),
        onLeaveBack: () => {
            const navbar = document.getElementById("navbar");
            if (navbar && !navbar.classList.contains('client-navbar')) {
                navbar.classList.remove("scrolled");
            }
        }
    });

    ScrollTrigger.batch(".reveal, .reveal-left, .reveal-right", {
        start: "top 88%",
        onEnter: (els) => {
            els.forEach(el => {
                gsap.to(el, { opacity: 1, x: 0, y: 0, duration: 0.8, ease: "power3.out" });
            });
        },
        once: true
    });

    // --- PARTICLES ---
    const particleContainer = document.getElementById("particles");
    if (particleContainer && particleContainer.children.length === 0) {
        const count = window.innerWidth < 768 ? 8 : 16;
        for (let i = 0; i < count; i++) {
            const p = document.createElement("div");
            p.className = "particle";
            const size = Math.random() * 120 + 40;
            p.style.cssText = `width:${size}px;height:${size}px;left:${Math.random()*100}%;animation-duration:${Math.random()*15+10}s;animation-delay:${Math.random()*-20}s;opacity:${Math.random()*0.4+0.05};`;
            particleContainer.appendChild(p);
        }
    }

    // --- STATS COUNTER ---
    document.querySelectorAll(".stat-number").forEach(el => {
        const target = parseInt(el.getAttribute("data-target") || "0", 10);
        ScrollTrigger.create({
            trigger: el,
            start: "top 80%",
            once: true,
            onEnter: () => {
                gsap.to({ val: 0 }, {
                    val: target, duration: 2, ease: "power2.out",
                    onUpdate: function () { el.textContent = Math.round(this.targets()[0].val); }
                });
            }
        });
    });

    // --- LIGHTBOX ---
    GLightbox({ selector: '.glightbox' });

    // --- GRADIENT TEXT ---
    if (document.querySelector(".gradient-text")) {
        gsap.to(".gradient-text", {
            backgroundPosition: "200% center",
            duration: 4,
            ease: "none",
            repeat: -1,
            yoyo: true
        });
    }
};

document.addEventListener('livewire:navigated', initGlobalAnimations);
document.addEventListener('DOMContentLoaded', initGlobalAnimations);
