<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$mensaje = "";
if (isset($_SESSION["success_msg"])) {
    $mensaje = $_SESSION["success_msg"];
    unset($_SESSION["success_msg"]);
}

if (isset($_GET["id"]) && isset($_GET["confirmar"])) {
    $id = $_GET["id"];
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = :id AND rol = 'padre'");
    $stmt->execute([":id" => $id]);
    $mensaje = "Padre eliminado correctamente";
}

$padres = $conexion
    ->query("SELECT id, nombre, email FROM usuarios WHERE rol = 'padre'")
    ->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Gestión de Padres";
include "includes/header.php";
?>

<body>
    <div id="overlay" onclick="closeSidebar()"></div>

    <?php include "includes/sidebar.php"; ?>

    <main id="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="breadcrumb-bar">
                <h5>Padres de Familia</h5>
                <p>Panel Administrativo &nbsp;/&nbsp; Padres</p>
            </div>
        </div>

        <div class="content-area">
            <div class="gca-card p-4">
                <div class="section-header">
                    <h4><i class="bi bi-person-heart"></i> Padres registrados</h4>
                    <a href="crear_padre.php" class="btn-gca btn-gca-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Padre
                    </a>
                </div>

                <?php if ($mensaje): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <?= $mensaje ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table gca-table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($padres as $p): ?>
                                <tr>
                                    <td><span class="fw-semibold"><?= htmlspecialchars($p["nombre"]) ?></span></td>
                                    <td><?= htmlspecialchars($p["email"]) ?></td>
                                    <td class="text-end">
                                        <a href="editar_padre.php?id=<?= $p["id"] ?>" class="btn-action btn-edit me-1" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="ver_padres.php?id=<?= $p["id"] ?>&confirmar=1"
                                            class="btn-action btn-delete" title="Eliminar"
                                            onclick="event.preventDefault();showConfirm('¿Seguro que deseas eliminar este padre?',()=>window.location.href=this.href);">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (count($padres) === 0): ?>
                                <tr><td colspan="3" class="text-center text-muted py-4">No hay padres registrados.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
