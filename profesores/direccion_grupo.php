<?php
require_once __DIR__ . '/../includes/init.php';
checkRole('profesor');
require_once "../lib/rank_helper.php";

$profesor_id = userId();

/* ── Get active period ── */
$periodo_activo = getConfig('periodo_activo') ?? '1';

/* ── Get courses where this profesor is director ── */
$cursos_dirigidos = $conexion->prepare("
    SELECT c.id, c.grado, c.nombre AS curso_nombre, c.nivel
    FROM directores_grupo dg
    JOIN cursos c ON dg.curso_id = c.id
    WHERE dg.profesor_id = ?
    ORDER BY c.nivel, c.grado, c.nombre
");
$cursos_dirigidos->execute([$profesor_id]);
$cursos_dirigidos = $cursos_dirigidos->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Dirección de Grupo";
include "includes/header.php";
?>

<body>
    <div id="overlay" onclick="closeSidebar()"></div>
    <?php include "includes/sidebar.php"; ?>

    <main id="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="breadcrumb-bar">
                <h5><i class="ti ti-users"></i> Dirección de Grupo</h5>
                <p>Panel del Profesor &nbsp;/&nbsp; Vista Consolidada</p>
            </div>
        </div>

        <div class="content-area">

            <?php if (count($cursos_dirigidos) === 0): ?>
                <div class="gca-card empty-state p-5">
                    <i class="bi bi-people" style="font-size:52px;color:#ddd;"></i>
                    <h4 style="font-family:'Cormorant Garamond',serif;color:#444;font-weight:700;">Sin grupo a cargo</h4>
                    <p class="text-muted mb-0">No tienes ningún curso asignado como director de grupo.</p>
                </div>
            <?php else: ?>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                    <div class="section-header mb-0">
                        <h4><i class="bi bi-eye"></i> Vista Consolidada</h4>
                    </div>
                    <span class="badge bg-dark rounded-pill px-3 py-1" style="color:var(--gold);font-size:11px;">
                        <i class="bi bi-calendar3"></i> Período <?= $periodo_activo ?>
                    </span>
                </div>

                <div class="accordion" id="accordionDirector">
                    <?php foreach ($cursos_dirigidos as $curso):
                        $estudiantes = $conexion->prepare("
                            SELECT id, nombre, documento FROM estudiantes WHERE curso_id = ? ORDER BY nombre
                        ");
                        $estudiantes->execute([$curso['id']]);
                        $estudiantes = $estudiantes->fetchAll(PDO::FETCH_ASSOC);

                        $materias_curso = $conexion->prepare("
                            SELECT DISTINCT a.id, a.nombre, a.area
                            FROM profesor_curso_asignatura pca
                            JOIN asignaturas a ON pca.asignatura_id = a.id
                            WHERE pca.curso_id = ?
                            ORDER BY a.area, a.nombre
                        ");
                        $materias_curso->execute([$curso['id']]);
                        $materias_curso = $materias_curso->fetchAll(PDO::FETCH_ASSOC);

                        $ranking = obtenerRankingCurso($conexion, $curso['id'], $periodo_activo);
                        $ranking_map = [];
                        foreach ($ranking as $i => $r) {
                            $ranking_map[$r['id']] = ['pos' => $i + 1, 'total' => count($ranking)];
                        }

                        // Eager-load all notas + logros for all students in this course (1 query)
                        $notas_map_por_est = [];
                        if (count($estudiantes) > 0) {
                            $est_ids = array_column($estudiantes, 'id');
                            $placeholders = implode(',', array_fill(0, count($est_ids), '?'));
                            $params = array_merge($est_ids, [$periodo_activo]);
                            $notas_all = $conexion->prepare("
                                SELECT n.estudiante_id, n.asignatura_id, n.nota, n.profesor_id,
                                       u.nombre AS profesor_nombre, l.logro
                                FROM notas n
                                JOIN usuarios u ON n.profesor_id = u.id
                                LEFT JOIN logros l ON l.estudiante_id = n.estudiante_id
                                    AND l.asignatura_id = n.asignatura_id
                                    AND l.periodo = n.periodo
                                WHERE n.estudiante_id IN ($placeholders) AND n.periodo = ?
                            ");
                            $notas_all->execute($params);
                            foreach ($notas_all->fetchAll(PDO::FETCH_ASSOC) as $row) {
                                $eid = $row['estudiante_id'];
                                $notas_map_por_est[$eid][$row['asignatura_id']] = $row;
                            }
                        }
                    ?>
                        <div class="accordion-item mb-3" style="border-radius:14px!important;border:1px solid #ece8e0;overflow:hidden;">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseDir<?= $curso['id'] ?>"
                                    style="font-family:'Cormorant Garamond',serif;font-weight:700;font-size:16px;color:#1a1a1a;background:#fcfbfa;">
                                    <i class="bi bi-book-fill me-2" style="color:var(--gold);"></i>
                                    <?= htmlspecialchars(ucfirst($curso['nivel'] ?? '') . ' - ' . $curso['grado'] . ' ' . $curso['curso_nombre']) ?>
                                    <span class="badge bg-secondary ms-2 rounded-pill"><?= count($estudiantes) ?> est.</span>
                                </button>
                            </h2>
                            <div id="collapseDir<?= $curso['id'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionDirector">
                                <div class="accordion-body p-0">

                                    <?php if (count($estudiantes) === 0): ?>
                                        <div class="p-4 text-center text-muted">No hay estudiantes en este curso.</div>
                                    <?php elseif (count($materias_curso) === 0): ?>
                                        <div class="p-4 text-center text-muted">No hay materias asignadas a este curso.</div>
                                    <?php else: ?>
                                        <div class="accordion" id="accordionEstDir<?= $curso['id'] ?>">
                                            <?php foreach ($estudiantes as $est):
                                                $notas_map = $notas_map_por_est[$est['id']] ?? [];
                                            ?>
                                                <div class="accordion-item" style="border-left:3px solid var(--gold);border-radius:0;">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseEstDir<?= $est['id'] ?>"
                                                            style="font-size:13px;background:#fff;">
                                                            <i class="bi bi-person-fill me-2" style="color:var(--gold-dark);"></i>
                                                            <?= htmlspecialchars($est['nombre']) ?>
                                                            <?php if (isset($ranking_map[$est['id']])): ?>
                                                                <span style="margin-left:12px;font-size:10px;font-weight:700;color:var(--gold-dark);background:rgba(212,175,55,0.1);padding:1px 8px;border-radius:20px;white-space:nowrap;">
                                                                    #<?= $ranking_map[$est['id']]['pos'] ?>/<?= $ranking_map[$est['id']]['total'] ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <span style="margin-left:auto;font-size:11px;color:#999;"><?= htmlspecialchars($est['documento']) ?></span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseEstDir<?= $est['id'] ?>" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionEstDir<?= $curso['id'] ?>">
                                                        <div class="accordion-body p-0">
                                                            <div class="table-responsive">
                                                                <table class="table gca-table mb-0" style="font-size:12px;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Área</th>
                                                                            <th>Asignatura</th>
                                                                            <th>Docente</th>
                                                                            <th style="width:70px;">Nota</th>
                                                                            <th>Logro</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($materias_curso as $mat):
                                                                            $tiene = $notas_map[$mat['id']] ?? null;
                                                                        ?>
                                                                            <tr>
                                                                                <td style="color:#888;"><?= htmlspecialchars($mat['area']) ?></td>
                                                                                <td class="fw-medium"><?= htmlspecialchars($mat['nombre']) ?></td>
                                                                                <td style="font-size:11px;color:#666;">
                                                                                    <?= $tiene ? htmlspecialchars($tiene['profesor_nombre']) : '—' ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php if ($tiene): ?>
                                                                                        <span class="badge rounded-pill px-2 py-1
                                                                                            <?= $tiene['nota'] >= 60 ? 'bg-success' : ($tiene['nota'] >= 40 ? 'bg-warning text-dark' : 'bg-danger') ?>">
                                                                                            <?= (int) $tiene['nota'] ?>
                                                                                        </span>
                                                                                    <?php else: ?>
                                                                                        <span style="color:#ccc;">—</span>
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td style="font-size:11px;color:#666;max-width:200px;">
                                                                                    <?= $tiene && $tiene['logro'] ? htmlspecialchars($tiene['logro']) : '—' ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex align-items-center gap-3 mt-4 p-3 gca-card" style="background:#fcfbfa;">
                    <i class="bi bi-info-circle-fill" style="color:var(--gold);font-size:20px;"></i>
                    <div>
                        <p class="mb-0 small">
                            <strong>Vista de solo lectura.</strong> Como director de grupo puedes visualizar
                            las notas de <strong>todas las materias</strong> registradas por los docentes de tu curso.
                            Las notas de tus propias asignaturas se gestionan desde <a href="registrar_notas.php"
                            style="color:var(--gold-dark);font-weight:500;">Registrar Notas</a>.
                        </p>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
