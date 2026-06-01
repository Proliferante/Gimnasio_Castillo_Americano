    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('select:not(.no-ts)').forEach(function(el) {
                new TomSelect(el, { maxOptions: 100, placeholder: el.options[0]?.text || 'Seleccionar...', allowEmptyOption: true });
            });
        });

        // ── Dark Mode ──
        (function() {
            const isDark = localStorage.getItem('gca-dark-mode') === 'true';
            if (isDark) {
                document.body.classList.add('dark-mode');
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            }
        })();
    </script>
</body>
</html>
