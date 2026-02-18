const STORAGE_KEY = 'theme';

// apply theme
function applyTheme(theme) {

    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

}

// get system theme
function getSystemTheme() {

    return window.matchMedia('(prefers-color-scheme: dark)').matches
        ? 'dark'
        : 'light';

}

// init theme
export function initTheme() {

    const stored = localStorage.getItem(STORAGE_KEY);

    // use stored only as initial preference
    if (stored === 'dark' || stored === 'light') {

        applyTheme(stored);

    } else {

        applyTheme(getSystemTheme());

    }

}

// toggle manual (temporary)
export function toggleTheme() {

    const isDark = document.documentElement.classList.contains('dark');

    const newTheme = isDark ? 'light' : 'dark';

    localStorage.setItem(STORAGE_KEY, newTheme);

    applyTheme(newTheme);

}

// ALWAYS follow system changes (override everything)
export function watchSystemTheme() {

    const media = window.matchMedia('(prefers-color-scheme: dark)');

    media.addEventListener('change', (e) => {

        const newTheme = e.matches ? 'dark' : 'light';

        applyTheme(newTheme);

        // optional: sync storage
        localStorage.setItem(STORAGE_KEY, newTheme);

    });

}
