(function () {
    'use strict';

    function initThemeToggle() {
        var html = document.documentElement;
        try {
            var saved = localStorage.getItem('site-theme');
            if (saved) html.setAttribute('data-bs-theme', saved);
        } catch (e) {}

        var btn = document.querySelector('[data-theme-toggle]');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var current = html.getAttribute('data-bs-theme') || 'light';
            var next = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-bs-theme', next);
            try { localStorage.setItem('site-theme', next); } catch (e) {}
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initThemeToggle);
    } else {
        initThemeToggle();
    }
})();
