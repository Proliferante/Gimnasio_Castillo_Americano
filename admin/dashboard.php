<?php

require_once __DIR__ . '/../includes/init.php';
checkRole('admin');

$nombre_admin = htmlspecialchars(userName() ?? "Administrador");

$total_usuarios = $conexion->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
$total_profesores = $conexion->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'profesor'")->fetchColumn();
$total_estudiantes_usuarios = $conexion->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'estudiante'")->fetchColumn();
$total_estudiantes = $conexion->query("SELECT COUNT(*) FROM estudiantes")->fetchColumn();
$total_padres = $conexion->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'padre'")->fetchColumn();
$total_cursos = $conexion->query("SELECT COUNT(*) FROM cursos")->fetchColumn();
$total_asignaturas = $conexion->query("SELECT COUNT(*) FROM asignaturas")->fetchColumn();

$ultimos_estudiantes = $conexion
    ->query("SELECT e.id, e.nombre, e.documento, c.grado, c.nombre AS curso_nombre, e.creado_en
        FROM estudiantes e
        LEFT JOIN cursos c ON e.curso_id = c.id
        ORDER BY e.creado_en DESC
        LIMIT 8")
    ->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Panel Administrativo";
include "includes/header.php";
?>

<style>
    .welcome-banner {
        background: linear-gradient(135deg, #0d1b2a 0%, #1b2838 100%);
        border-radius: 20px;
        padding: 32px 36px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 28px;
        border: 1px solid rgba(212, 175, 55, 0.15);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .welcome-banner h2 {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700;
        color: #f0ede6;
        font-size: 28px;
        margin: 0 0 4px;
    }

    .welcome-banner h2 span {
        color: #d4af37;
    }

    .welcome-banner p {
        color: rgba(240, 237, 230, 0.6);
        margin: 0;
        font-size: 14.5px;
    }

    .welcome-icon {
        font-size: 48px;
        color: #d4af37;
        opacity: 0.6;
        flex-shrink: 0;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 22px 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        border: 1px solid #ece8e0;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .stat-icon.users {
        background: rgba(13, 27, 42, 0.08);
        color: #0d1b2a;
    }

    .stat-icon.profesores {
        background: rgba(212, 175, 55, 0.15);
        color: #b8962e;
    }

    .stat-icon.estudiantes {
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
    }

    .stat-icon.padres {
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }

    .stat-icon.cursos {
        background: rgba(111, 66, 193, 0.1);
        color: #6f42c1;
    }

    .stat-icon.asignaturas {
        background: rgba(253, 126, 20, 0.1);
        color: #fd7e14;
    }

    .stat-label {
        font-size: 13px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .stat-value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.1;
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #d4af37;
        font-size: 22px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
        margin-bottom: 32px;
    }

    .quick-action {
        background: #fff;
        border: 1px solid #ece8e0;
        border-radius: 14px;
        padding: 18px 20px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.2s;
        color: #444;
    }

    .quick-action:hover {
        border-color: #d4af37;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.12);
        color: #1a1a1a;
    }

    .quick-action i {
        font-size: 22px;
        color: #d4af37;
        width: 28px;
        text-align: center;
        flex-shrink: 0;
    }

    .quick-action span {
        font-size: 14px;
        font-weight: 500;
    }

    .recent-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #ece8e0;
        overflow: hidden;
    }

    .recent-card .list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 22px;
        border-bottom: 1px solid #f0ede8;
        transition: background 0.15s;
    }

    .recent-card .list-item:last-child {
        border-bottom: none;
    }

    .recent-card .list-item:hover {
        background: #fcfbfa;
    }

    .recent-card .list-item .item-name {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 14.5px;
    }

    .recent-card .list-item .item-meta {
        font-size: 12.5px;
        color: #999;
    }

    .recent-card .list-item .item-email {
        font-size: 13px;
        color: #777;
    }

    .recent-card .empty-message {
        padding: 32px;
        text-align: center;
        color: #aaa;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .welcome-banner {
            flex-direction: column;
            text-align: center;
            padding: 24px 20px;
        }

        .quick-actions {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>

<body>
    <div id="overlay" onclick="closeSidebar()"></div>

    <?php include "includes/sidebar.php"; ?>

    <main id="main">

        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()" title="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <div class="breadcrumb-bar">
                <h5>Panel Administrativo</h5>
                <p>Gimnasio Castillo Americano &nbsp;/&nbsp; Inicio</p>
            </div>
        </div>

        <div class="content-area">

            <div class="welcome-banner">
                <div>
                    <h2>Bienvenido, <span><?= $nombre_admin ?></span></h2>
                    <p>Panel de control del sistema académico &mdash; Gimnasio Castillo Americano</p>
                </div>
                <i class="bi bi-shield-check welcome-icon"></i>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="stat-card">
                        <div class="stat-icon users"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <div class="stat-label">Cuentas</div>
                            <div class="stat-value"><?= $total_usuarios ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="stat-card">
                        <div class="stat-icon profesores"><i class="bi bi-person-workspace"></i></div>
                        <div>
                            <div class="stat-label">Profesores</div>
                            <div class="stat-value"><?= $total_profesores ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="stat-card">
                        <div class="stat-icon estudiantes"><i class="bi bi-mortarboard-fill"></i></div>
                        <div>
                            <div class="stat-label">Estudiantes</div>
                            <div class="stat-value"><?= $total_estudiantes ?></div>
                            <div style="font-size:11px;color:#999;"><?= $total_estudiantes_usuarios ?> con cuenta</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="stat-card">
                        <div class="stat-icon padres"><i class="bi bi-person-heart"></i></div>
                        <div>
                            <div class="stat-label">Padres</div>
                            <div class="stat-value"><?= $total_padres ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="stat-card">
                        <div class="stat-icon cursos"><i class="bi bi-journal-check"></i></div>
                        <div>
                            <div class="stat-label">Cursos</div>
                            <div class="stat-value"><?= $total_cursos ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-2">
                    <div class="stat-card">
                        <div class="stat-icon asignaturas"><i class="bi bi-book-fill"></i></div>
                        <div>
                            <div class="stat-label">Asignaturas</div>
                            <div class="stat-value"><?= $total_asignaturas ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-title"><i class="bi bi-lightning-fill"></i> Acciones rápidas</div>
            <div class="quick-actions">
                <a href="crear_admin.php" class="quick-action">
                    <i class="bi bi-shield-plus"></i>
                    <span>Nuevo Admin</span>
                </a>
                <a href="crear_profesor.php" class="quick-action">
                    <i class="bi bi-person-plus"></i>
                    <span>Nuevo Profesor</span>
                </a>
                <a href="crear_estudiante.php" class="quick-action">
                    <i class="bi bi-mortarboard-plus"></i>
                    <span>Nuevo Estudiante</span>
                </a>
                <a href="crear_padre.php" class="quick-action">
                    <i class="bi bi-heart-plus"></i>
                    <span>Nuevo Padre</span>
                </a>
                <a href="crear_curso.php" class="quick-action">
                    <i class="bi bi-plus-square"></i>
                    <span>Nuevo Curso</span>
                </a>
                <a href="crear_asignatura.php" class="quick-action">
                    <i class="bi bi-bookmark-plus"></i>
                    <span>Nueva Asignatura</span>
                </a>
                <a href="asignar_profesor.php" class="quick-action">
                    <i class="bi bi-link-45deg"></i>
                    <span>Asignar Materia</span>
                </a>
                <a href="asignar_padre.php" class="quick-action">
                    <i class="bi bi-people"></i>
                    <span>Asignar Hijo</span>
                </a>
                <a href="plataforma.php" class="quick-action">
                    <i class="bi bi-display"></i>
                    <span>Plataforma</span>
                </a>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="section-title"><i class="bi bi-clock-history"></i> Últimos estudiantes registrados</div>
                    <div class="recent-card">
                        <?php if (count($ultimos_estudiantes) > 0): ?>
                            <?php foreach ($ultimos_estudiantes as $est):
                                $cursoStr = $est['grado'] ? ucfirst($est['grado']) . ' - ' . $est['curso_nombre'] : '—';
                            ?>
                                <div class="list-item">
                                    <div>
                                        <div class="item-name"><?= htmlspecialchars($est["nombre"]) ?></div>
                                        <div class="item-email">Doc: <?= htmlspecialchars($est["documento"]) ?> · Curso: <?= htmlspecialchars($cursoStr) ?></div>
                                    </div>
                                    <div class="item-meta"><?= date("d/m/Y", strtotime($est["creado_en"])) ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-message">No hay estudiantes registrados aún.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="section-title"><i class="bi bi-info-circle"></i> Resumen del sistema</div>
                    <div class="recent-card">
                        <div class="list-item">
                            <span class="item-name">Versión del sistema</span>
                            <span class="item-meta">v3.0</span>
                        </div>
                        <div class="list-item">
                            <span class="item-name">Total de usuarios en plataforma</span>
                            <span class="item-meta"><?= $total_usuarios ?></span>
                        </div>
                        <div class="list-item">
                            <span class="item-name">Cursos activos</span>
                            <span class="item-meta"><?= $total_cursos ?></span>
                        </div>
                        <div class="list-item">
                            <span class="item-name">Asignaturas registradas</span>
                            <span class="item-meta"><?= $total_asignaturas ?></span>
                        </div>
                        <div class="list-item">
                            <span class="item-name">Estudiantes en plataforma</span>
                            <span class="item-meta"><?= $total_estudiantes ?></span>
                        </div>
                        <div class="list-item">
                            <span class="item-name">Relación estudiante/profesor</span>
                            <span class="item-meta">
                                <?= $total_profesores > 0 ? round($total_estudiantes / $total_profesores, 1) . ':1' : '—' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php include "includes/footer.php"; ?>