(function () {
    'use strict';

    function initEditor() {
        var el = document.getElementById('content-md-editor');
        if (!el || typeof EasyMDE === 'undefined') return;
        new EasyMDE({
            element: el,
            spellChecker: false,
            autosave: { enabled: false },
            status: ['lines', 'words', 'cursor'],
            toolbar: [
                'bold', 'italic', 'heading', '|',
                'quote', 'unordered-list', 'ordered-list', '|',
                'link', 'image', 'code', 'table', 'horizontal-rule', '|',
                'preview', 'side-by-side', 'fullscreen', '|',
                'guide'
            ],
            minHeight: '500px'
        });
    }

    function initThemeToggle() {
        var btn = document.querySelector('[data-theme-toggle]');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var html = document.documentElement;
            var current = html.getAttribute('data-bs-theme') || 'light';
            var next = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-bs-theme', next);
            try { localStorage.setItem('admin-theme', next); } catch (e) {}
        });
        try {
            var saved = localStorage.getItem('admin-theme');
            if (saved) document.documentElement.setAttribute('data-bs-theme', saved);
        } catch (e) {}
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { initEditor(); initThemeToggle(); });
    } else {
        initEditor();
        initThemeToggle();
    }
})();
