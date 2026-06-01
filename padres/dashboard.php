<?php

require_once __DIR__ . '/../includes/init.php';
checkRole('padre');

$padre_id = userId();
$nombre_padre = $_SESSION["nombre"] ?? "Padre de Familia";

/* ── Get children ── */
$hijos = $conexion->prepare("
    SELECT e.id, e.nombre, e.documento,
           c.grado, c.nombre AS curso_nombre
    FROM estudiantes e
    LEFT JOIN cursos c ON e.curso_id = c.id
    WHERE e.padre_id = ?
    ORDER BY e.nombre
");
$hijos->execute([$padre_id]);
$hijos = $hijos->fetchAll(PDO::FETCH_ASSOC);

/* ── Get unread alerts ── */
$alertas_padre = $conexion->prepare("
    SELECT * FROM alertas
    WHERE (para_usuario_id = ? OR (para_rol = 'padre' AND para_usuario_id IS NULL))
    AND leido = 0
    ORDER BY created_at DESC
    LIMIT 5
");
$alertas_padre->execute([$padre_id]);
$alertas_padre = $alertas_padre->fetchAll(PDO::FETCH_ASSOC);

/* ── Check for available boletines ── */
$hijos_ids = array_column($hijos, 'id');
$boletines_disponibles = [];
if (count($hijos_ids) > 0) {
    $placeholders = implode(',', array_fill(0, count($hijos_ids), '?'));
    $stmtB = $conexion->prepare("
        SELECT DISTINCT bp.estudiante_id, bp.periodo, bp.year, e.nombre AS estudiante_nombre
        FROM boletines_pdf bp
        JOIN estudiantes e ON bp.estudiante_id = e.id
        WHERE bp.estudiante_id IN ($placeholders)
        ORDER BY bp.estudiante_id, bp.periodo
    ");
    $stmtB->execute($hijos_ids);
    foreach ($stmtB->fetchAll(PDO::FETCH_ASSOC) as $b) {
        $boletines_disponibles[$b['estudiante_id']][] = $b;
    }
}

$pageTitle = "Mis Hijos";
include "includes/header.php";
?>

<body>

    <!-- App header -->
    <header class="app-header">
        <a href="dashboard.php" class="app-header-brand">
            <img src="../assets/img/logo_gca.png" alt="GCA">
            <div>
                <span>Familia GCA</span>
                <small>Panel de Padres</small>
            </div>
        </a>
        <a href="../auth/logout.php" class="btn-header">
            <i class="bi bi-box-arrow-right"></i> Salir
        </a>
    </header>

    <main class="app-content">

        <!-- Welcome -->
        <div style="margin-bottom:20px;">
            <h5 style="font-family:'Cormorant Garamond',serif;font-weight:700;color:#1a1a1a;margin:0;font-size:22px;">
                <i class="bi bi-house-fill" style="color:var(--gold);margin-right:8px;"></i>Mis Hijos
            </h5>
            <p style="color:var(--text-secondary);font-size:13px;margin:4px 0 0;">
                <?php
                $h = (int)date('H');
                $saludo = $h < 12 ? 'Buenos días' : ($h < 18 ? 'Buenas tardes' : 'Buenas noches');
                ?><?= $saludo ?>, <?= htmlspecialchars($nombre_padre) ?> — selecciona un hijo para ver su boletín
            </p>
        </div>

        <?php if (count($alertas_padre) > 0): ?>
            <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:16px;">
                <?php foreach ($alertas_padre as $al): ?>
                    <div style="background:#fff3f3;border-left:4px solid #dc3545;border-radius:10px;padding:10px 14px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-exclamation-triangle-fill" style="color:#dc3545;font-size:16px;margin-top:1px;"></i>
                            <div>
                                <strong style="font-size:13px;color:#1a1a1a;"><?= htmlspecialchars($al['titulo']) ?></strong>
                                <p style="font-size:12px;color:#666;margin:2px 0 0;"><?= nl2br(htmlspecialchars($al['mensaje'])) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (count($hijos) === 0): ?>
            <div class="app-card">
                <div class="empty-state">
                    <i class="bi bi-people"></i>
                    <h5>Sin estudiantes vinculados</h5>
                    <p>No hay hijos asignados a tu cuenta. Consulta con la administración del colegio.</p>
                </div>
            </div>
        <?php else: ?>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <?php foreach ($hijos as $h):
                    $h_boletines = $boletines_disponibles[$h['id']] ?? [];
                ?>
                    <a href="boletin.php?estudiante=<?= $h['id'] ?>" class="student-card">
                        <div class="student-avatar">
                            <?= strtoupper(substr($h['nombre'], 0, 2)) ?>
                        </div>
                        <div class="student-info">
                            <h6><?= htmlspecialchars($h['nombre']) ?></h6>
                            <p>
                                <?php if ($h['grado']): ?>
                                    Curso <?= htmlspecialchars($h['grado'] . ' ' . $h['curso_nombre']) ?>
                                <?php else: ?>
                                    Sin curso asignado
                                <?php endif; ?>
                            </p>
                            <div style="display:flex;gap:4px;flex-wrap:wrap;">
                                <?php if ($h['grado']): ?>
                                    <span class="badge-curso">
                                        <i class="bi bi-book-fill" style="font-size:9px;"></i>
                                        <?= htmlspecialchars($h['grado']) ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (count($h_boletines) > 0): ?>
                                    <span style="background:#e8f5e9;color:#2e7d32;font-size:10px;font-weight:600;padding:1px 8px;border-radius:20px;">
                                        <i class="bi bi-file-pdf-fill"></i> PDF
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right student-chevron"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Footer info -->
        <div style="text-align:center;margin-top:32px;padding-top:20px;border-top:1px solid var(--border);">
            <p style="font-size:11px;color:var(--text-muted);margin:0;">
                <i class="bi bi-shield-check me-1"></i>
                Gimnasio Castillo Americano &middot; Boletín Académico
            </p>
        </div>

    </main>

    <?php include "includes/footer.php"; ?>
