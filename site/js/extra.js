// Ajouter le label de langage sur les blocs de code
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre > code[class*="language-"]').forEach(code => {
        const lang = code.className.match(/language-(\w+)/)?.[1];
        if (!lang || lang === 'text') return;

        const labels = {
            php: 'PHP', bash: 'Shell', json: 'JSON', html: 'HTML',
            css: 'CSS', js: 'JavaScript', sql: 'SQL', env: '.env', md: 'Markdown'
        };

        const label = document.createElement('span');
        label.className = 'code-lang-label';
        label.textContent = labels[lang] || lang.toUpperCase();
        label.style.cssText = `
            position: absolute; top: 10px; left: 16px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 1px;
            color: rgba(168,85,247,0.5);
            pointer-events: none;
        `;
        const pre = code.parentElement;
        pre.style.position = 'relative';
        pre.insertBefore(label, code);
    });
});
