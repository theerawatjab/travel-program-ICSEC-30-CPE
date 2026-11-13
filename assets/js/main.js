(() => {
    'use strict';

    const root = document.documentElement;
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------------- Hero slider ---------------- */
    const hero = document.querySelector('[data-hero]');
    if (hero) {
        const bgs = [...hero.querySelectorAll('.hero__bg')];
        const pageBgs = [...document.querySelectorAll('.page-bg')];
        const texts = [...hero.querySelectorAll('.hero__text')];
        const cards = [...hero.querySelectorAll('.card')];
        const nums = [...hero.querySelectorAll('.pager__num')];
        const dots = [...hero.querySelectorAll('.rail__dot')];
        const rail = hero.querySelector('.rail');
        const pager = hero.querySelector('.pager');
        const counter = hero.querySelector('[data-current]');
        const playBtn = hero.querySelector('[data-play]');
        const total = texts.length;
        const DELAY = 7000;

        let current = 0;
        let playing = !reduceMotion;
        let timer = null;

        const pad = (n) => String(n).padStart(2, '0');

        const schedule = () => {
            clearTimeout(timer);
            if (playing && !document.hidden) timer = setTimeout(() => go(current + 1), DELAY);
            playBtn.classList.toggle('is-playing', playing);
        };

        function go(index) {
            current = (index + total) % total;
            const active = texts[current];

            root.style.setProperty('--accent', active.dataset.accent);
            root.style.setProperty('--bg-top', active.dataset.bgTop);
            root.style.setProperty('--bg-bottom', active.dataset.bgBottom);

            bgs.forEach((el, i) => el.classList.toggle('is-active', i === current));
            pageBgs.forEach((el, i) => el.classList.toggle('is-active', i === current));

            texts.forEach((el, i) => {
                const on = i === current;
                el.classList.toggle('is-active', on);
                el.setAttribute('aria-hidden', String(!on));
                el.querySelector('.btn').tabIndex = on ? 0 : -1;
            });

            // การ์ด: สไลด์ปัจจุบันเลื่อนออกซ้าย ที่เหลือเรียงตามลำดับถัดไป
            cards.forEach((card, i) => {
                const pos = i === current ? -1 : (i - current - 1 + total) % total;
                card.dataset.pos = pos;
                card.style.setProperty('--p', pos);
                card.tabIndex = pos === -1 ? -1 : 0;
            });

            nums.forEach((el, i) => el.classList.toggle('is-active', i === current));
            dots.forEach((el, i) => el.classList.toggle('is-passed', i <= current));

            const progress = total > 1 ? (current / (total - 1)) * 100 : 0;
            rail.style.setProperty('--progress', progress + '%');
            pager.style.setProperty('--i', current);
            counter.textContent = pad(current + 1);

            schedule();
        }

        hero.querySelector('[data-prev]').addEventListener('click', () => go(current - 1));
        hero.querySelector('[data-next]').addEventListener('click', () => go(current + 1));
        cards.forEach((card) => card.addEventListener('click', () => go(Number(card.dataset.index))));
        nums.forEach((btn) => btn.addEventListener('click', () => go(Number(btn.dataset.goto))));
        playBtn.addEventListener('click', () => { playing = !playing; schedule(); });

        // ปุ่มลูกศรบนคีย์บอร์ด (เฉพาะตอนเห็น hero)
        let heroVisible = true;
        new IntersectionObserver(([entry]) => { heroVisible = entry.isIntersecting; }, { threshold: 0.3 }).observe(hero);
        document.addEventListener('keydown', (ev) => {
            if (!heroVisible || ev.target.closest('input, textarea')) return;
            if (ev.key === 'ArrowRight') go(current + 1);
            if (ev.key === 'ArrowLeft') go(current - 1);
        });

        // ปัดซ้าย/ขวาบนมือถือ
        let startX = null;
        hero.addEventListener('pointerdown', (ev) => { startX = ev.clientX; });
        hero.addEventListener('pointerup', (ev) => {
            if (startX === null) return;
            const dx = ev.clientX - startX;
            startX = null;
            if (Math.abs(dx) > 60) go(current + (dx < 0 ? 1 : -1));
        });

        document.addEventListener('visibilitychange', schedule);
        go(0);
    }

    /* ---------------- เมนู ---------------- */
    const menuBtn = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-menu]');
    if (menuBtn && menu) {
        const setMenu = (open) => {
            menu.classList.toggle('is-open', open);
            menuBtn.setAttribute('aria-expanded', String(open));
        };
        menuBtn.addEventListener('click', (ev) => { ev.stopPropagation(); setMenu(!menu.classList.contains('is-open')); });
        menu.addEventListener('click', (ev) => { if (ev.target.closest('a')) setMenu(false); });
        document.addEventListener('click', (ev) => { if (!menu.contains(ev.target)) setMenu(false); });
        document.addEventListener('keydown', (ev) => { if (ev.key === 'Escape') setMenu(false); });
    }

    /* ---------------- ไฮไลต์แท็บวันตามตำแหน่งที่เลื่อน ---------------- */
    const tabs = [...document.querySelectorAll('.day-tab')];
    if (tabs.length) {
        const spy = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const id = '#' + entry.target.id;
                tabs.forEach((t) => t.classList.toggle('is-active', t.getAttribute('href') === id));
            });
        }, { rootMargin: '-40% 0px -55% 0px' });
        document.querySelectorAll('.day').forEach((d) => spy.observe(d));
    }

    /* ---------------- ค่อย ๆ แสดงเนื้อหาตอนเลื่อนถึง ---------------- */
    const reveals = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window) || reduceMotion) {
        reveals.forEach((el) => el.classList.add('is-visible'));
    } else {
        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach((el) => io.observe(el));
    }
})();
