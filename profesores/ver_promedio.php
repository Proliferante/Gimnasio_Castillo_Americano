<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "profesor") {
    header("Location: ../login.php");
    exit;
}

$profesor_id = $_SESSION["id"];

/* Get the teacher's courses */
$cursos = $conexion->prepare("
    SELECT DISTINCT c.id, c.grado, c.nombre
    FROM profesor_curso_asignatura pca
    JOIN cursos c ON pca.curso_id = c.id
    WHERE pca.profesor_id = ?
    ORDER BY c.grado, c.nombre
");
$cursos->execute([$profesor_id]);
$cursos = $cursos->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Ver Promedios";
include "includes/header.php";
?>

<body>
    <div id="overlay" onclick="closeSidebar()"></div>
    <?php include "includes/sidebar.php"; ?>

    <main id="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="breadcrumb-bar">
                <h5><i class="ti ti-chart-bar"></i> Ver Promedios</h5>
                <p>Panel del Profesor &nbsp;/&nbsp; Rendimiento Académico</p>
            </div>
        </div>

        <div class="content-area">

            <?php if (count($cursos) === 0): ?>
                <div class="gca-card empty-state p-5">
                    <i class="bi bi-inbox"></i>
                    <h4 style="font-family:'Cormorant Garamond',serif;color:#444;font-weight:700;">Sin asignaciones</h4>
                    <p class="text-muted mb-0">Aún no tienes cursos asignados. Consulta con la administración.</p>
                </div>
            <?php else: ?>
                <div class="accordion" id="accordionCursos">
                    <?php foreach ($cursos as $i => $curso):
                        $promedios = $conexion->prepare("
                            SELECT e.nombre AS estudiante,
                                   a.nombre AS asignatura,
                                   ROUND(AVG(n.nota), 1) AS promedio
                            FROM notas n
                            JOIN estudiantes e ON n.estudiante_id = e.id
                            JOIN asignaturas a ON n.asignatura_id = a.id
                            JOIN profesor_curso_asignatura pca
                                 ON pca.curso_id = n.curso_id
                                 AND pca.asignatura_id = n.asignatura_id
                            WHERE n.curso_id = ? AND pca.profesor_id = ?
                            GROUP BY e.id, a.id
                            ORDER BY e.nombre, a.nombre
                        ");
                        $promedios->execute([$curso['id'], $profesor_id]);
                        $promedios = $promedios->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                        <div class="accordion-item mb-3" style="border-radius:14px !important;border:1px solid #ece8e0;overflow:hidden;">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?= $i > 0 ? 'collapsed' : '' ?>" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#curso<?= $curso['id'] ?>"
                                    style="font-family:'Cormorant Garamond',serif;font-weight:700;font-size:18px;color:#1a1a1a;background:#fcfbfa;">
                                    <i class="bi bi-book-fill me-2" style="color:var(--gold);"></i>
                                    Curso <?= htmlspecialchars($curso['grado'] . ' ' . $curso['nombre']) ?>
                                </button>
                            </h2>
                            <div id="curso<?= $curso['id'] ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>"
                                data-bs-parent="#accordionCursos">
                                <div class="accordion-body p-0">
                                    <?php if (count($promedios) > 0): ?>
                                        <div class="table-responsive">
                                            <table class="table gca-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Estudiante</th>
                                                        <th>Asignatura</th>
                                                        <th style="width:120px;">Promedio</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($promedios as $p):
                                                        $prom = (float) $p['promedio'];
                                                        if ($prom >= 60) $badgeClass = 'bg-success';
                                                        elseif ($prom >= 40) $badgeClass = 'bg-warning text-dark';
                                                        else $badgeClass = 'bg-danger';
                                                    ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($p['estudiante']) ?></td>
                                                            <td><?= htmlspecialchars($p['asignatura']) ?></td>
                                                            <td>
                                                                <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1 fs-6 fw-semibold">
                                                                    <?= $prom ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-4 text-muted">
                                            <i class="bi bi-journal-x d-block fs-2 mb-1"></i>
                                            Sin notas registradas en este curso.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <?php include "includes/footer.php"; ?>
