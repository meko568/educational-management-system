import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

const applyTheme = (theme) => {
    const root = document.documentElement;

    root.classList.remove('dark');

    if (theme === 'dark') {
        root.classList.add('dark');
        return;
    }

    if (theme === 'system') {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            root.classList.add('dark');
        }
    }
};

window.setTheme = (theme) => {
    localStorage.setItem('theme', theme);
    applyTheme(theme);
};

(() => {
    const saved = localStorage.getItem('theme') || 'system';
    applyTheme(saved);

    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            const current = localStorage.getItem('theme') || 'system';
            if (current === 'system') {
                applyTheme('system');
            }
        });
    }
})();

Alpine.start();
