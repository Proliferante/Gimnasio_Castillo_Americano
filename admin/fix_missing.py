import os
from refactor_forms import get_template

def rewrite(filename, title, content):
    with open(filename, 'r', encoding='utf-8') as f:
        html = f.read()
    import re
    php_match = re.search(r'^(<\?php.*?\?>)', html, re.DOTALL)
    php_code = php_match.group(1) if php_match else ""
    
    new_html = get_template(title, content)
    
    with open(filename, 'w', encoding='utf-8') as f:
        f.write(php_code + "\n" + new_html)

# asignar_padre
content_ap = """
<div class="card p-4">
    <h4 class="mb-4 text-center">Asignar Padre a Estudiante</h4>
    <?php if ($mensaje): ?>
        <div class="alert alert-success text-center">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Padre</label>
            <select class="form-select" name="padre_id" required>
                <option value="">Seleccione padre</option>
                <?php foreach ($padres as $p): ?>
                    <option value="<?php echo $p["id"]; ?>">
                        <?php echo htmlspecialchars($p["nombre"]); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label class="form-label">Estudiante</label>
            <select class="form-select" name="estudiante_id" required>
                <option value="">Seleccione estudiante</option>
                <?php foreach ($estudiantes as $e): ?>
                    <option value="<?php echo $e["id"]; ?>">
                        <?php echo htmlspecialchars($e["nombre"]); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Asignar Padre</button>
    </form>
</div>
"""
rewrite("asignar_padre.php", "Asignar Padre", content_ap)

# crear_asignatura
content_ca = """
<div class="card p-4">
    <h4 class="mb-4 text-center">Crear Asignatura</h4>
    <form method="POST">
        <div class="mb-4">
            <label class="form-label">Nombre de la asignatura</label>
            <input type="text" name="nombre" class="form-control" placeholder="Ej: Matemáticas" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Crear Asignatura</button>
    </form>
</div>
"""
rewrite("crear_asignatura.php", "Crear Asignatura", content_ca)
