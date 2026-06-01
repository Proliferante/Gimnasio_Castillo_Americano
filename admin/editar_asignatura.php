<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

require_once "../config/database.php";

$mensaje = "";
$tipo = "";

if (!isset($_GET["id"])) {
    header("Location: ver_asignaturas.php");
    exit;
}

$id = $_GET["id"];

$stmt = $conexion->prepare("SELECT id, nombre FROM asignaturas WHERE id = :id");
$stmt->execute([":id" => $id]);
$asignatura = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$asignatura) {
    header("Location: ver_asignaturas.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");

    if ($nombre === "") {
        $mensaje = "El nombre de la asignatura es obligatorio.";
        $tipo = "danger";
    } else {
        try {
            $sql = "UPDATE asignaturas SET nombre = :nombre WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([":nombre" => $nombre, ":id" => $id]);

            $_SESSION["success_msg"] = "Asignatura actualizada correctamente.";
            header("Location: ver_asignaturas.php");
            exit;
        } catch (PDOException $e) {
            $mensaje = "Error al actualizar la asignatura.";
            $tipo = "danger";
        }
    }
}

$pageTitle = "Editar Asignatura";
include "includes/header.php";
?>

<body>
    <div id="overlay" onclick="closeSidebar()"></div>

    <?php include "includes/sidebar.php"; ?>

    <main id="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="breadcrumb-bar">
                <h5>Editar Asignatura</h5>
                <p>Panel Administrativo &nbsp;/&nbsp; Editar Asignatura</p>
            </div>
        </div>

        <div class="content-area">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card card-form p-4 p-md-5">

                        <div class="header-box">
                            <img src="../assets/img/logo_gca.png" alt="GCA">
                            <h4>Editar Asignatura</h4>
                            <span>Gimnasio Castillo Americano</span>
                        </div>

                        <?php if ($mensaje): ?>
                            <div class="alert alert-<?= $tipo ?> alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($mensaje) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" autocomplete="off">
                            <div class="mb-4">
                                <label class="form-label fw-medium">Nombre de la asignatura</label>
                                <input type="text" name="nombre" class="form-control"
                                    value="<?= htmlspecialchars($_POST["nombre"] ?? $asignatura["nombre"]) ?>" required
                                    placeholder="Ej. MATEMATICAS">
                            </div>

                            <button type="submit" class="btn-gca w-100">
                                <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                            </button>

                            <a href="ver_asignaturas.php" class="btn-outline-gca w-100 justify-content-center mt-2">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
