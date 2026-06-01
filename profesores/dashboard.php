<?php

require_once __DIR__ . '/../includes/init.php';
checkRole('profesor');

$profesor_id = userId();
$nombre = $_SESSION["nombre"] ?? "Profesor";

/* ── Stats ── */
$totalEstudiantes = $conexion->prepare("
    SELECT COUNT(DISTINCT e.id)
    FROM estudiantes e
    JOIN profesor_curso_asignatura pca ON e.curso_id = pca.curso_id
    WHERE pca.profesor_id = ?
");
$totalEstudiantes->execute([$profesor_id]);
$totalEstudiantes = (int) $totalEstudiantes->fetchColumn();

$totalCursos = $conexion->prepare("
    SELECT COUNT(DISTINCT pca.curso_id)
    FROM profesor_curso_asignatura pca
    WHERE pca.profesor_id = ?
");
$totalCursos->execute([$profesor_id]);
$totalCursos = (int) $totalCursos->fetchColumn();

$totalAsignaturas = $conexion->prepare("
    SELECT COUNT(DISTINCT pca.asignatura_id)
    FROM profesor_curso_asignatura pca
    WHERE pca.profesor_id = ?
");
$totalAsignaturas->execute([$profesor_id]);
$totalAsignaturas = (int) $totalAsignaturas->fetchColumn();

$totalNotas = $conexion->prepare("
    SELECT COUNT(*) FROM notas WHERE profesor_id = ?
");
$totalNotas->execute([$profesor_id]);
$totalNotas = (int) $totalNotas->fetchColumn();

/* ── Recent grades ── */
$recientes = $conexion->prepare("
    SELECT n.nota, n.periodo, n.creado_en,
           e.nombre AS estudiante, a.nombre AS asignatura,
           c.grado, c.nombre AS curso
    FROM notas n
    JOIN estudiantes e ON n.estudiante_id = e.id
    JOIN asignaturas a ON n.asignatura_id = a.id
    JOIN cursos c ON n.curso_id = c.id
    WHERE n.profesor_id = ?
    ORDER BY n.creado_en DESC
    LIMIT 8
");
$recientes->execute([$profesor_id]);
$recientes = $recientes->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Dashboard";
include "includes/header.php";
?>

<body>
    <div id="overlay" onclick="closeSidebar()"></div>
    <?php include "includes/sidebar.php"; ?>

    <main id="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="breadcrumb-bar">
                <h5><i class="ti ti-layout-dashboard"></i> Dashboard</h5>
                <p>Panel del Profesor &nbsp;/&nbsp; Resumen Académico</p>
            </div>
        </div>

        <div class="content-area">
            <!-- Welcome banner -->
            <div class="gca-card p-4 mb-4" style="background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%); border-color: rgba(212,175,55,0.2);">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div style="width:56px;height:56px;background:linear-gradient(135deg,var(--gold),var(--gold-dark));border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:26px;color:#000;flex-shrink:0;box-shadow:0 4px 16px rgba(212,175,55,0.3);">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <h3 style="font-family:'Cormorant Garamond',serif;color:var(--gold);margin:0;font-size:24px;">
                            Bienvenido, <?= htmlspecialchars($nombre) ?>
                        </h3>
                        <p style="color:var(--text-muted);margin:2px 0 0;font-size:13px;">
                            Panel de control académico &middot; Gestión de calificaciones y seguimiento
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stat cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon gold"><i class="bi bi-people-fill"></i></div>
                        <div class="stat-info">
                            <h3><?= $totalEstudiantes ?></h3>
                            <p>Estudiantes</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="bi bi-book-fill"></i></div>
                        <div class="stat-info">
                            <h3><?= $totalCursos ?></h3>
                            <p>Cursos</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="bi bi-journal-text"></i></div>
                        <div class="stat-info">
                            <h3><?= $totalAsignaturas ?></h3>
                            <p>Asignaturas</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon purple"><i class="bi bi-star-fill"></i></div>
                        <div class="stat-info">
                            <h3><?= $totalNotas ?></h3>
                            <p>Notas Registradas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick actions + Recent grades -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="section-header"><h4><i class="bi bi-lightning-fill"></i> Acceso Rápido</h4></div>
                    <div class="d-flex flex-column gap-3">
                        <a href="registrar_notas.php" class="quick-card">
                            <i class="bi bi-pencil-square"></i>
                            <h6>Registrar Notas</h6>
                            <p>Ingresa las calificaciones de tus estudiantes</p>
                        </a>
                        <a href="ver_promedio.php" class="quick-card">
                            <i class="bi bi-bar-chart-line"></i>
                            <h6>Ver Promedios</h6>
                            <p>Consulta el rendimiento académico</p>
                        </a>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="section-header">
                        <h4><i class="bi bi-clock-history"></i> Notas Recientes</h4>
                    </div>
                    <div class="gca-card">
                        <?php if (count($recientes) > 0): ?>
                            <div class="table-responsive">
                                <table class="table gca-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Estudiante</th>
                                            <th>Asignatura</th>
                                            <th>Curso</th>
                                            <th>Periodo</th>
                                            <th>Nota</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recientes as $r): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($r["estudiante"]) ?></td>
                                                <td><?= htmlspecialchars($r["asignatura"]) ?></td>
                                                <td><?= htmlspecialchars($r["grado"] . ' ' . $r["curso"]) ?></td>
                                                <td><?= htmlspecialchars($r["periodo"]) ?></td>
                                                <td>
                                                    <span class="badge <?= $r["nota"] >= 60 ? 'bg-success' : 'bg-danger' ?> rounded-pill px-3 py-1">
                                                        <?= (int) $r["nota"] ?>
                                                    </span>
                                                </td>
                                                <td style="font-size:12px;color:#999;"><?= date("d/m/Y", strtotime($r["creado_en"])) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p class="mb-0">Aún no has registrado ninguna nota.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
