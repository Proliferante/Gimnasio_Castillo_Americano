<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $pageTitle; ?> | Padres · GCA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --gold: #d4af37;
            --gold-dark: #b8962e;
            --gold-light: #f0d060;
            --gold-glow: rgba(212,175,55,.08);
            --radius: 16px;
            --radius-sm: 10px;

            --bg-body: #f5f3ee;
            --bg-card: #ffffff;
            --bg-card-hover: #fcfbfa;
            --bg-surface: #f8f7f4;
            --bg-input: #fff;
            --bg-dark: #0f1117;
            --surface: #ffffff;
            --surface-alt: #f8f7f4;
            --text-primary: #1a1a1a;
            --text-secondary: #666;
            --text-muted: #999;
            --border: #ece8e0;
            --border-input: #ddd;
            --form-bg: #fff;
            --alert-bg: #fef2f2;
            --alert-color: #b91c1c;
        }

        body.dark-mode {
            --bg-body: #0f1117;
            --bg-card: #1a1d27;
            --bg-card-hover: #1e2130;
            --bg-surface: #1a1d27;
            --bg-input: #222639;
            --bg-dark: #0a0b10;
            --surface: #1a1d27;
            --surface-alt: #1a1d27;
            --text-primary: #e8e6e0;
            --text-secondary: #aaa;
            --text-muted: #777;
            --border: #2a2d3a;
            --border-input: #333750;
            --form-bg: #1a1d27;
            --alert-bg: rgba(220,38,38,.12);
            --alert-color: #f87171;
        }

        body { transition: background .25s, color .25s; }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            padding: 0;
            margin: 0;
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(212, 175, 55, 0.25); border-radius: 2px; }

        /* ── Fixed top bar (app-style) ── */
        .app-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: var(--bg-dark);
            border-bottom: 2px solid var(--gold);
            padding: 0 16px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .app-header-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .app-header-brand img {
            height: 36px;
            filter: brightness(1.1);
        }

        .app-header-brand span {
            font-family: 'Cormorant Garamond', serif;
            color: var(--gold);
            font-size: 18px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .app-header-brand small {
            display: block;
            color: rgba(255,255,255,0.4);
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: 'Outfit', sans-serif;
            font-weight: 500;
        }

        .btn-header {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border: 1px solid rgba(212,175,55,0.2);
            border-radius: var(--radius-sm);
            color: var(--gold);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
            background: transparent;
            font-family: 'Outfit', sans-serif;
        }

        .btn-header:hover {
            background: rgba(212,175,55,0.08);
            border-color: rgba(212,175,55,0.35);
            color: var(--gold-light);
        }

        /* ── Main content ── */
        .app-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px 16px;
        }

        /* ── Cards ── */
        .app-card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: transform .2s, box-shadow .2s;
        }

        .app-card:active {
            transform: scale(0.98);
        }

        .app-card-header {
            padding: 18px 20px 0;
        }

        .app-card-body {
            padding: 16px 20px 20px;
        }

        /* ── Student card ── */
        .student-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 18px;
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            text-decoration: none;
            transition: all .2s;
            cursor: pointer;
        }

        .student-card:hover {
            border-color: var(--gold);
            box-shadow: 0 4px 16px rgba(212,175,55,0.10);
        }

        .student-card:active {
            transform: scale(0.97);
        }

        .student-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(212,175,55,0.25);
        }

        .student-info { flex: 1; min-width: 0; }
        .student-info h6 {
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            font-size: 15px;
        }
        .student-info p {
            margin: 2px 0 0;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .student-info .badge-curso {
            display: inline-block;
            background: rgba(212,175,55,0.1);
            color: var(--gold-dark);
            font-size: 10px;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 20px;
            margin-top: 4px;
        }

        .student-chevron {
            color: #ccc;
            font-size: 18px;
            flex-shrink: 0;
        }

        /* ── Grade card ── */
        .grade-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid #f0ede8;
        }

        .grade-card:last-child {
            border-bottom: none;
        }

        .grade-card:hover {
            background: #faf8f5;
        }

        .grade-card .subject-name {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 14px;
        }

        .grade-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }

        .grade-badge.high { background: rgba(25,135,84,0.12); color: #198754; }
        .grade-badge.medium { background: rgba(255,193,7,0.15); color: #997404; }
        .grade-badge.low { background: rgba(220,53,69,0.1); color: #dc3545; }

        /* ── Average pill ── */
        .avg-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 18px;
        }

        .avg-pill.high { background: rgba(25,135,84,0.1); color: #198754; }
        .avg-pill.medium { background: rgba(255,193,7,0.12); color: #997404; }
        .avg-pill.low { background: rgba(220,53,69,0.1); color: #dc3545; }

        /* ── Period tabs ── */
        .period-tabs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 4px;
            scrollbar-width: none;
        }

        .period-tabs::-webkit-scrollbar { display: none; }

        .period-tab {
            flex-shrink: 0;
            padding: 10px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            border: 1.5px solid var(--border);
            background: var(--surface);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            font-family: 'Outfit', sans-serif;
        }

        .period-tab:hover {
            border-color: var(--gold);
            color: var(--gold-dark);
        }

        .period-tab.active {
            background: var(--bg-dark);
            border-color: var(--gold);
            color: var(--gold);
        }

        .period-tab i { margin-right: 6px; }

        /* ── Section title ── */
        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i { color: var(--gold); }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        .empty-state i { font-size: 44px; color: #ddd; margin-bottom: 10px; display: block; }
        .empty-state h5 { font-family: 'Cormorant Garamond', serif; color: #444; font-weight: 700; }
        .empty-state p { color: var(--text-muted); font-size: 13px; margin-bottom: 0; }

        /* ── Student header in boletín ── */
        .student-header {
            text-align: center;
            padding: 20px 0 24px;
        }

        .student-header .big-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 28px;
            margin: 0 auto 10px;
            box-shadow: 0 6px 20px rgba(212,175,55,0.25);
        }

        .student-header h4 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .student-header p {
            color: var(--text-secondary);
            font-size: 13px;
            margin: 0;
        }

        /* ── Utility ── */
        .text-gold { color: var(--gold-dark); }
        .fw-medium { font-weight: 500; }

        @media (max-width: 480px) {
            .app-content { padding: 16px 12px; }
            .app-header { padding: 0 12px; }
            .app-header-brand span { font-size: 16px; }
            .app-header-brand img { height: 30px; }
        }

        @media (min-width: 768px) {
            .app-content { max-width: 640px; padding: 28px 24px; }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>
        .ts-wrapper .ts-control {
            border-radius: 10px; padding: 10px 14px; border: 1.5px solid var(--border-input);
            font-size: 14px; min-height: 46px; display: flex; align-items: center;
            background: var(--bg-input); color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            transition: border-color .2s, box-shadow .2s, background .25s;
        }
        .ts-wrapper.focus .ts-control {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px var(--gold-glow);
        }
        .ts-wrapper .ts-dropdown {
            border: 1px solid var(--border); border-radius: 12px;
            background: var(--bg-card);
            box-shadow: 0 8px 40px rgba(0,0,0,.15);
            margin-top: 4px; overflow: hidden;
            font-family: 'Outfit', sans-serif;
        }
        .ts-wrapper .ts-dropdown .option {
            padding: 10px 14px; font-size: 14px;
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
        }
        .ts-wrapper .ts-dropdown .option.active { background: var(--gold-glow); }
        .ts-wrapper .ts-dropdown .option.selected {
            background: rgba(201,162,77,.15); font-weight: 600;
        }
        .ts-wrapper .ts-dropdown .option.selected::after { content: ' ✓'; color: var(--gold-dark); font-weight: 700; }
    </style>
    <!-- ── Dark Mode overrides ── -->
    <style>
        .dark-mode,
        [data-bs-theme="dark"] {
            color-scheme: dark;
        }
        .dark-mode table,
        .dark-mode .table,
        .dark-mode .card,
        .dark-mode .gca-card,
        .dark-mode .card-form,
        .dark-mode .stats-card,
        .dark-mode .modal-content,
        .dark-mode .list-group-item,
        .dark-mode .dropdown-menu,
        .dark-mode .accordion-item,
        .dark-mode .accordion-button,
        .dark-mode .page-link,
        .dark-mode .page-item.disabled .page-link,
        .dark-mode .ts-control,
        .dark-mode .ts-dropdown,
        .dark-mode .form-control,
        .dark-mode .form-select {
            background-color: var(--bg-surface);
            color: var(--text-primary);
            border-color: var(--border);
        }
        .dark-mode .table-striped > tbody > tr:nth-of-type(odd) > * {
            background-color: rgba(0,0,0,.15);
            color: var(--text-primary);
        }
        .dark-mode .table-hover > tbody > tr:hover > * {
            background-color: rgba(212,175,55,.06);
            color: var(--text-primary);
        }
        .dark-mode .accordion-button:not(.collapsed) {
            background-color: rgba(212,175,55,.08);
            color: var(--gold);
        }
        .dark-mode .page-link {
            background-color: var(--bg-surface);
            border-color: var(--border);
            color: var(--text-primary);
        }
        .dark-mode .page-link:hover {
            background-color: rgba(212,175,55,.1);
            color: var(--gold);
        }
        .dark-mode .page-item.active .page-link {
            background-color: var(--gold);
            border-color: var(--gold);
            color: #000;
        }
        .dark-mode .page-item.disabled .page-link {
            background-color: rgba(0,0,0,.2);
            color: var(--text-muted);
        }
        .dark-mode .modal-header,
        .dark-mode .modal-footer {
            border-color: var(--border);
        }
        .dark-mode .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        .dark-mode .breadcrumb-item.active {
            color: var(--text-primary);
        }
        .dark-mode .breadcrumb-item + .breadcrumb-item::before {
            color: var(--text-muted);
        }
        .dark-mode .form-control::placeholder,
        .dark-mode .form-select::placeholder {
            color: var(--text-muted);
        }
        .dark-mode .alert {
            background-color: var(--alert-bg);
            color: var(--alert-color);
            border-color: var(--border);
        }
        .dark-mode .ts-dropdown .option.active {
            background: rgba(212,175,55,.12);
            color: var(--gold);
        }
        .dark-mode .ts-wrapper .ts-control {
            background: var(--bg-surface);
            color: var(--text-primary);
            border-color: var(--border);
        }
        .dark-mode .ts-wrapper.multi .ts-control > div .remove {
            border-color: rgba(212,175,55,.15);
            color: var(--text-muted);
        }
        .dark-mode .ts-wrapper.multi .ts-control > div .remove:hover {
            background: rgba(212,175,55,.15);
        }
    </style>
</head>
