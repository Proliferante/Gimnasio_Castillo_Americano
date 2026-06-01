import os
import re

def get_template(title, content):
    return f"""<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{title} | Gimnasio Castillo Americano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {{
            --gold: #d4af37;
            --gold-dark: #b8962e;
            --gold-light: #f0d060;
            --bg: #0a0a0a;
            --sidebar-w: 320px;
            --surface: #131313;
            --surface2: #1c1c1c;
            --text: #f0ede6;
            --muted: #888;
            --accent-line: 1px solid rgba(212, 175, 55, 0.18);
        }}

        * {{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }}

        body {{
            font-family: 'Outfit', sans-serif;
            background: #f2efe8;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }}

        /* ── SIDEBAR ── */
        #sidebar {{
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: transform .3s cubic-bezier(.4, 0, .2, 1);
            border-right: var(--accent-line);
        }}

        #sidebar.collapsed {{
            transform: translateX(-100%);
        }}

        .sidebar-logo {{
            padding: 32px 28px 24px;
            border-bottom: var(--accent-line);
            display: flex;
            align-items: center;
            gap: 16px;
        }}

        .sidebar-logo img {{
            height: 56px;
            filter: brightness(1.1);
        }}

        .sidebar-logo-text {{
            line-height: 1.2;
        }}

        .sidebar-logo-text span {{
            display: block;
            font-family: 'Cormorant Garamond', serif;
            color: var(--gold);
            font-size: 18px;
            letter-spacing: .5px;
        }}

        .sidebar-logo-text small {{
            color: var(--muted);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: 'Outfit', sans-serif;
        }}

        .admin-badge {{
            margin: 18px 22px;
            background: rgba(212, 175, 55, 0.08);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }}

        .admin-avatar {{
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 18px;
            flex-shrink: 0;
        }}

        .admin-info span {{
            display: block;
            color: var(--text);
            font-size: 14.5px;
            font-weight: 600;
        }}

        .admin-info small {{
            color: var(--muted);
            font-size: 11px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }}

        /* Nav */
        .sidebar-nav {{
            flex: 1;
            padding: 8px 0 20px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(212, 175, 55, 0.2) transparent;
        }}

        .nav-section-label {{
            padding: 20px 28px 8px;
            font-size: 10.5px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(212, 175, 55, 0.45);
            font-weight: 600;
        }}

        .nav-parent {{
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 28px;
            color: #c0bdb6;
            font-size: 15.5px;
            font-weight: 500;
            cursor: pointer;
            user-select: none;
            border-left: 3px solid transparent;
            transition: all .2s;
            position: relative;
        }}

        .nav-parent:hover {{
            color: var(--gold);
            background: rgba(212, 175, 55, 0.05);
        }}

        .nav-parent.active {{
            color: var(--gold);
            border-left-color: var(--gold);
            background: rgba(212, 175, 55, 0.07);
        }}

        .nav-parent .nav-icon {{
            font-size: 20px;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
        }}

        .nav-parent .chevron {{
            margin-left: auto;
            font-size: 13px;
            transition: transform .25s;
            color: var(--muted);
        }}

        .nav-parent.open .chevron {{
            transform: rotate(90deg);
            color: var(--gold);
        }}

        /* Submenu */
        .nav-submenu {{
            overflow: hidden;
            max-height: 0;
            transition: max-height .35s cubic-bezier(.4, 0, .2, 1);
        }}

        .nav-submenu.open {{
            max-height: 400px;
        }}

        .nav-sub-item {{
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 28px 10px 58px;
            color: #888;
            font-size: 14px;
            text-decoration: none;
            transition: all .18s;
            border-left: 3px solid transparent;
        }}

        .nav-sub-item::before {{
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(212, 175, 55, 0.3);
            flex-shrink: 0;
            transition: background .18s;
        }}

        .nav-sub-item:hover {{
            color: var(--gold-light);
            background: rgba(212, 175, 55, 0.04);
            border-left-color: rgba(212, 175, 55, 0.3);
        }}

        .nav-sub-item:hover::before {{
            background: var(--gold);
        }}

        .nav-sub-item.danger {{
            color: #c0495a;
        }}

        .nav-sub-item.danger::before {{
            background: rgba(192, 73, 90, 0.3);
        }}

        .nav-sub-item.danger:hover {{
            color: #e05566;
            background: rgba(192, 73, 90, 0.06);
            border-left-color: rgba(192, 73, 90, 0.3);
        }}

        .nav-sub-item.danger:hover::before {{
            background: #e05566;
        }}

        /* Sidebar footer */
        .sidebar-footer {{
            padding: 16px 20px;
            border-top: var(--accent-line);
        }}

        .btn-logout {{
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 12px 18px;
            background: transparent;
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 14px;
            color: var(--muted);
            font-size: 14px;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
        }}

        .btn-logout:hover {{
            background: rgba(212, 175, 55, 0.06);
            color: var(--gold);
            border-color: rgba(212, 175, 55, 0.4);
        }}

        /* ── MAIN CONTENT ── */
        #main {{
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            transition: margin-left .3s cubic-bezier(.4, 0, .2, 1);
            min-height: 100vh;
        }}

        #main.expanded {{
            margin-left: 0;
        }}

        /* Topbar */
        .topbar {{
            background: #fff;
            border-bottom: 1px solid #e5e0d5;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 50;
        }}

        .toggle-btn {{
            background: none;
            border: none;
            font-size: 20px;
            color: #555;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 8px;
            transition: background .2s;
        }}

        .toggle-btn:hover {{
            background: #f0ede8;
        }}

        .breadcrumb-bar {{
            flex: 1;
        }}

        .breadcrumb-bar h5 {{
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            color: #1a1a1a;
            margin: 0;
        }}

        .breadcrumb-bar p {{
            font-size: 12.5px;
            color: #999;
            margin: 0;
            letter-spacing: .3px;
        }}

        /* Content area */
        .content-area {{
            padding: 36px 40px;
            flex: 1;
        }}

        /* Overlay for mobile */
        #overlay {{
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 99;
        }}
        
        /* Form specific styles */
        .card {{
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .03);
            border: 1px solid #ece8e0;
            background: #fff;
        }}
        
        .card h4 {{
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            color: #111;
        }}
        
        .form-label {{
            font-weight: 500;
            color: #444;
            font-size: 14px;
        }}
        
        .form-control, .form-select {{
            border-radius: 10px;
            border: 1px solid #dfdad0;
            padding: 10px 14px;
            font-family: 'Outfit', sans-serif;
            background-color: #fbfbfb;
            box-shadow: none;
        }}
        .form-control:focus, .form-select:focus {{
            border-color: var(--gold);
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.15);
            background-color: #fff;
        }}
        
        .btn-primary {{
            background-color: var(--gold);
            border-color: var(--gold-dark);
            color: #000;
            font-weight: 600;
            border-radius: 10px;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(212, 175, 55, 0.3);
        }}
        .btn-primary:hover {{
            background-color: var(--gold-dark);
            border-color: #a08020;
            color: #fff;
        }}
        .btn-danger {{
            border-radius: 10px;
            padding: 10px 20px;
        }}

        @media (max-width: 768px) {{
            #sidebar {{
                transform: translateX(-100%);
            }}

            #sidebar.open {{
                transform: translateX(0);
            }}

            #main {{
                margin-left: 0 !important;
            }}

            #overlay {{
                display: block;
                opacity: 0;
                pointer-events: none;
                transition: opacity .3s;
            }}

            #overlay.show {{
                opacity: 1;
                pointer-events: all;
            }}

            .content-area {{
                padding: 20px 18px;
            }}
        }}

    </style>
</head>

<body>

    <!-- Overlay mobile -->
    <div id="overlay" onclick="closeSidebar()"></div>

    <!-- ══ SIDEBAR ══ -->
    <nav id="sidebar">

        <div class="sidebar-logo">
            <img src="../assets/img/logo_gca.png" alt="GCA" onerror="this.src=''; this.alt='GCA';">
            <div class="sidebar-logo-text">
                <span>Castillo Americano</span>
                <small>Panel Admin</small>
            </div>
        </div>

        <div class="admin-badge">
            <div class="admin-avatar"><i class="bi bi-person-fill"></i></div>
            <div class="admin-info">
                <span>Administrador</span>
                <small>Sesión activa</small>
            </div>
        </div>

        <div class="sidebar-nav">

            <div class="nav-section-label">Gestión</div>

            <!-- USUARIOS -->
            <div class="nav-parent" onclick="toggleMenu(this)">
                <i class="bi bi-people-fill nav-icon"></i>
                Usuarios
                <i class="bi bi-chevron-right chevron"></i>
            </div>
            <div class="nav-submenu">
                <a href="crear_admin.php" class="nav-sub-item">Crear Administrador</a>
                <a href="crear_profesor.php" class="nav-sub-item">Crear Profesor</a>
                <a href="crear_padre.php" class="nav-sub-item">Crear Padre</a>
                <a href="eliminar_padre.php" class="nav-sub-item danger">Eliminar Padre</a>
            </div>

            <!-- PROFESORES -->
            <div class="nav-parent" onclick="toggleMenu(this)">
                <i class="bi bi-person-workspace nav-icon"></i>
                Profesores
                <i class="bi bi-chevron-right chevron"></i>
            </div>
            <div class="nav-submenu">
                <a href="asignar_profesor.php" class="nav-sub-item">Asignar Profesor</a>
                <a href="crear_asignatura.php" class="nav-sub-item">Crear Asignatura</a>
                <a href="eliminar_profesor.php" class="nav-sub-item danger">Eliminar Profesor</a>
            </div>

            <!-- ESTUDIANTES -->
            <div class="nav-parent" onclick="toggleMenu(this)">
                <i class="bi bi-mortarboard-fill nav-icon"></i>
                Estudiantes
                <i class="bi bi-chevron-right chevron"></i>
            </div>
            <div class="nav-submenu">
                <a href="crear_estudiante.php" class="nav-sub-item">Crear Estudiante</a>
                <a href="asignar_estudiante.php" class="nav-sub-item">Asignar Estudiante</a>
                <a href="eliminar_estudiante.php" class="nav-sub-item danger">Eliminar Estudiante</a>
            </div>

            <!-- CURSOS -->
            <div class="nav-parent" onclick="toggleMenu(this)">
                <i class="bi bi-journal-check nav-icon"></i>
                Cursos
                <i class="bi bi-chevron-right chevron"></i>
            </div>
            <div class="nav-submenu">
                <a href="crear_curso.php" class="nav-sub-item">Crear Curso</a>
                <a href="eliminar_curso.php" class="nav-sub-item danger">Eliminar Curso</a>
            </div>

            <div class="nav-section-label">Reportes</div>

            <a href="plataforma.php" class="nav-parent" style="text-decoration:none;">
                <i class="bi bi-display nav-icon"></i>
                Plataforma
            </a>

            <div class="nav-section-label">Sistema</div>

            <a href="../index.php" class="nav-parent" style="text-decoration:none;">
                <i class="bi bi-house-door nav-icon"></i>
                Sitio Web
            </a>

        </div>

        <div class="sidebar-footer">
            <a href="../auth/logout.php" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i>
                Cerrar sesión
            </a>
        </div>

    </nav>

    <!-- ══ MAIN ══ -->
    <main id="main">

        <!-- Topbar -->
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()" title="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <div class="breadcrumb-bar">
                <h5>{title}</h5>
                <p>Panel Administrativo &nbsp;/&nbsp; {title}</p>
            </div>
        </div>

        <!-- Content -->
        <div class="content-area">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    {content}
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMenu(el) {{
            const submenu = el.nextElementSibling;
            const isOpen = submenu.classList.contains('open');

            // Close all
            document.querySelectorAll('.nav-submenu.open').forEach(s => s.classList.remove('open'));
            document.querySelectorAll('.nav-parent.open').forEach(p => p.classList.remove('open'));

            if (!isOpen) {{
                submenu.classList.add('open');
                el.classList.add('open');
            }}

            // Keep active state
            document.querySelectorAll('.nav-parent.active').forEach(p => {{
                if (p !== el) p.classList.remove('active');
            }});
            el.classList.add('active');
        }}

        function toggleSidebar() {{
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('main');
            const overlay = document.getElementById('overlay');

            if (window.innerWidth <= 768) {{
                sidebar.classList.toggle('open');
                overlay.classList.toggle('show');
            }} else {{
                sidebar.classList.toggle('collapsed');
                main.classList.toggle('expanded');
            }}
        }}

        function closeSidebar() {{
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('overlay').classList.remove('show');
        }}

        // Highlight active sub-item based on current page
        const currentPage = location.pathname.split('/').pop();
        document.querySelectorAll('.nav-sub-item').forEach(link => {{
            const href = link.getAttribute('href');
            if (href && href.includes(currentPage) && currentPage !== '') {{
                link.style.color = '#d4af37';
                link.style.fontWeight = '600';
                
                // Open parent menus automatically
                let submenu = link.closest('.nav-submenu');
                if (submenu) {{
                    submenu.classList.add('open');
                    let parent = submenu.previousElementSibling;
                    if (parent && parent.classList.contains('nav-parent')) {{
                        parent.classList.add('open');
                    }}
                }}
            }}
        }});
    </script>
</body>
</html>"""

files_to_process = [
    "asignar_estudiante.php",
    "asignar_padre.php",
    "asignar_profesor.php",
    "crear_admin.php",
    "crear_asignatura.php",
    "crear_curso.php",
    "crear_estudiante.php",
    "crear_padre.php",
    "crear_profesor.php",
    "eliminar_curso.php",
    "eliminar_estudiante.php",
    "eliminar_padre.php",
    "eliminar_profesor.php"
]

for filename in files_to_process:
    if os.path.exists(filename):
        with open(filename, 'r', encoding='utf-8') as f:
            content = f.read()

        # Extract PHP block
        php_match = re.search(r'^(<\?php.*?\?>)', content, re.DOTALL)
        php_code = php_match.group(1) if php_match else ""

        # Extract Title
        title_match = re.search(r'<title>(.*?)</title>', content)
        if title_match:
            title = title_match.group(1).replace(' | Gimnasio Castillo Americano', '')
        else:
            title = "Gestión"

        # Extract Card content
        card_match = re.search(r'(<div class="card p-4">.*?</div>\s*</div>)', content, re.DOTALL)
        if card_match:
            # card_match.group(1) often ends up with too many unclosed divs. Let's precise it
            pass
        
        # A more robust approach for Card: find the first <div class="card p-4"> and find its matching closing </div>
        # But wait, python's regex makes bracket matching hard. 
        # Actually, since it's formatting, we can just split on <div class="container my-5"> or <div class="col-md-6">
        # Let's use string operations.
        
        start_idx = content.find('<div class="card')
        if start_idx == -1:
            print(f"Card not found in {filename}")
            continue
            
        # find matching closing div by counting open/close divs
        open_divs = 0
        end_idx = -1
        i = start_idx
        while i < len(content):
            if content[i:].startswith('<div'):
                open_divs += 1
                i += 4
            elif content[i:].startswith('</div'):
                open_divs -= 1
                i += 5
                if open_divs == 0:
                    end_idx = i + 1 # include the >
                    break
            else:
                i += 1
                
        if end_idx != -1:
            card_html = content[start_idx:end_idx]
            
            # Re-assemble
            new_html = get_template(title, card_html)
            final_content = php_code + "\n" + new_html
            
            with open(filename, 'w', encoding='utf-8') as f:
                f.write(final_content)
            print(f"Refactored {filename}")
        else:
            print(f"Could not parse card bounds in {filename}")

