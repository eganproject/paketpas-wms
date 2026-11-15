/**
 * Animasi landing page: memunculkan elemen saat masuk layar, memberi bayangan
 * pada header setelah digulir, dan menghitung "Barang 1 dari 3" di layar HP.
 * Semua efek visualnya ada di resources/css/landing.css.
 */
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function revealOnScroll() {
    const targets = document.querySelectorAll('[data-reveal], .lp-steps, .lp-chart');

    if (reduceMotion || !('IntersectionObserver' in window)) {
        targets.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

    targets.forEach((el) => observer.observe(el));
}

function headerShadow() {
    const header = document.querySelector('[data-header]');
    if (!header) return;

    const update = () => header.classList.toggle('is-scrolled', window.scrollY > 8);
    update();
    window.addEventListener('scroll', update, { passive: true });
}

function countLoops() {
    if (reduceMotion) return;

    document.querySelectorAll('[data-count-loop]').forEach((el) => {
        const values = el.dataset.countLoop.split(',');
        let i = 0;
        setInterval(() => {
            i = (i + 1) % values.length;
            el.textContent = values[i];
        }, 1100);
    });
}

function readingProgress() {
    const bar = document.querySelector('[data-progress]');
    if (!bar) return;

    const update = () => {
        const max = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.width = `${max > 0 ? Math.min(100, (window.scrollY / max) * 100) : 0}%`;
    };
    update();
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
}

function chapterNav() {
    const links = document.querySelectorAll('[data-chapter-link]');
    if (!links.length || !('IntersectionObserver' in window)) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            links.forEach((link) => link.classList.toggle('is-active', link.dataset.chapterLink === entry.target.id));
        });
    }, { rootMargin: '-45% 0px -45% 0px' });

    document.querySelectorAll('[data-chapter]').forEach((el) => observer.observe(el));
}

revealOnScroll();
headerShadow();
countLoops();
readingProgress();
chapterNav();
