<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('select:not(.no-ts)').forEach(function(el) {
            new TomSelect(el, {
                maxOptions: 100,
                placeholder: el.options[0]?.text || 'Seleccionar...',
                allowEmptyOption: true,
                onDropdownOpen: function() {
                    this.dropdown.style.maxHeight = '280px';
                    this.dropdown.style.overflowY = 'auto';
                }
            });
        });
    });
</script>
<script>
    function toggleMenu(el) {
        const submenu = el.nextElementSibling;
        if (!submenu || !submenu.classList.contains('nav-submenu')) return;

        const isOpen = submenu.classList.contains('open');
        document.querySelectorAll('.nav-submenu.open').forEach(s => s.classList.remove('open'));
        document.querySelectorAll('.nav-parent.open').forEach(p => p.classList.remove('open'));
        if (!isOpen) {
            submenu.classList.add('open');
            el.classList.add('open');
        }
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('main');
        const overlay = document.getElementById('overlay');
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
        }
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('show');
    }

    // Highlight active sub-item and open parent menu
    const currentPath = window.location.pathname;
    const currentPage = currentPath.substring(currentPath.lastIndexOf('/') + 1);

    document.querySelectorAll('.nav-sub-item').forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage) {
            link.classList.add('active-item');
            link.style.color = '#d4af37';
            link.style.fontWeight = '600';

            const submenu = link.closest('.nav-submenu');
            if (submenu) {
                submenu.classList.add('open');
                const parent = submenu.previousElementSibling;
                if (parent && parent.classList.contains('nav-parent')) {
                    parent.classList.add('open');
                    parent.classList.add('active');
                }
            }
        }
    });

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