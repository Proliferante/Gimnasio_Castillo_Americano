import os
import re

CSS = """
    <style>
        :root {
            --gold: #d4af37;
            --gold-dark: #b8962e;
            --gold-light: #f0d060;
            --bg: #0a0a0a;
            --text: #f0ede6;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f2efe8;
        }
        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            color: #1a1a1a;
            font-weight: 700;
        }
        .navbar {
            background-color: var(--bg) !important;
            border-bottom: 3px solid var(--gold);
        }
        .navbar-brand {
            color: var(--gold) !important;
            font-size: 20px;
        }
        .card, .card-form {
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
            border: 1px solid rgba(212,175,55,0.2);
            background: #fff;
            max-width: 600px;
            margin: auto;
        }
        .card.w-100 {
            max-width: 100%;
        }
        .btn-primary, .btn-gca {
            background-color: var(--gold);
            border-color: var(--gold);
            color: #000;
            font-weight: 600;
            border-radius: 30px;
            padding: 10px 20px;
        }
        .btn-primary:hover, .btn-gca:hover {
            background-color: var(--gold-dark);
            border-color: var(--gold-dark);
            color: #fff;
        }
        .btn-danger {
            background-color: #c0495a;
            border-color: #c0495a;
            border-radius: 30px;
        }
        .btn-danger:hover {
            background-color: #e05566;
            border-color: #e05566;
        }
        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 14px;
            border: 1px solid #ddd;
        }
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .table-dark {
            background-color: var(--bg);
            color: var(--text);
        }
        .table-dark th {
            background-color: var(--bg);
            color: var(--gold);
            border-color: rgba(212,175,55,0.2);
        }
        .header-box {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-box img {
            height: 70px;
            margin-bottom: 10px;
        }
        .header-box h4 {
            font-weight: 700;
            margin-bottom: 2px;
        }
        .header-box span {
            color: #777;
            font-size: 14px;
        }
    </style>
"""

FONTS = """
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
"""

directory = "."
for filename in os.listdir(directory):
    if filename.endswith(".php") and (filename.startswith("crear_") or filename.startswith("eliminar_") or (filename.startswith("asignar_"))):
        path = os.path.join(directory, filename)
        with open(path, "r", encoding="utf-8") as f:
            content = f.read()

        # Remove existing bootstrap links to avoid duplicates
        content = re.sub(r'<link[^>]*bootstrap[^>]*>', '', content)
        
        # Insert fonts and bootstrap before </head>
        content = content.replace("</head>", f"{FONTS}\n</head>")
        
        # Replace existing <style> tag or insert it before </head>
        if "<style>" in content and "</style>" in content:
            content = re.sub(r'<style>.*?</style>', CSS, content, flags=re.DOTALL)
        else:
            content = content.replace("</head>", f"{CSS}\n</head>")

        with open(path, "w", encoding="utf-8") as f:
            f.write(content)
        print(f"Updated {filename}")
