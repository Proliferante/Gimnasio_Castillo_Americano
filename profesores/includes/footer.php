    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('select:not(.no-ts)').forEach(function(el) {
                new TomSelect(el, { maxOptions: 100, placeholder: el.options[0]?.text || 'Seleccionar...', allowEmptyOption: true });
            });
        });
    </script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('open');
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
            overlay.classList.toggle('show');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main');
            const overlay = document.getElementById('overlay');
            sidebar.classList.remove('open');
            sidebar.classList.add('collapsed');
            main.classList.add('expanded');
            overlay.classList.remove('show');
        }

        // ── Dark Mode Toggle ──
        (function() {
            function applyDark(dark) {
                if (dark) {
                    document.body.classList.add('dark-mode');
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                } else {
                    document.body.classList.remove('dark-mode');
                    document.documentElement.removeAttribute('data-bs-theme');
                }
            }

            const isDark = localStorage.getItem('gca-dark-mode') === 'true';
            applyDark(isDark);

            const toggle = document.getElementById('darkModeToggle');
            if (!toggle) return;
            const icon = document.getElementById('dmIcon');
            const label = document.getElementById('dmLabel');

            function updateUI() {
                const dark = document.body.classList.contains('dark-mode');
                icon.className = dark ? 'bi bi-sun' : 'bi bi-moon-stars';
                label.textContent = dark ? 'Modo claro' : 'Modo oscuro';
            }

            updateUI();
            toggle.addEventListener('click', function() {
                const next = !document.body.classList.contains('dark-mode');
                applyDark(next);
                localStorage.setItem('gca-dark-mode', next);
                updateUI();
            });
        })();
    </script>
</body>
</html>
