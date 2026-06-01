<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

require_once "../config/database.php";

$mensaje = "";
$tipo = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");

    if ($nombre === "") {
        $mensaje = "El nombre de la asignatura es obligatorio.";
        $tipo = "danger";
    } else {
        try {
            $sql = "INSERT INTO asignaturas (nombre) VALUES (:nombre)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([":nombre" => $nombre]);

            $mensaje = "Asignatura creada correctamente.";
            $tipo = "success";
        } catch (PDOException $e) {
            $mensaje = "Error al crear la asignatura.";
            $tipo = "danger";
        }
    }
}

$pageTitle = "Crear Asignatura";
include "includes/header.php";
?>

<body>
    <div id="overlay" onclick="closeSidebar()"></div>

    <?php include "includes/sidebar.php"; ?>

    <main id="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="breadcrumb-bar">
                <h5>Crear Asignatura</h5>
                <p>Panel Administrativo &nbsp;/&nbsp; Nueva Asignatura</p>
            </div>
        </div>

        <div class="content-area">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card card-form p-4 p-md-5">

                        <div class="header-box">
                            <img src="../assets/img/logo_gca.png" alt="GCA">
                            <h4>Registro de Asignatura</h4>
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
                                    value="<?= htmlspecialchars($_POST["nombre"] ?? "") ?>" required
                                    placeholder="Ej. Matemáticas">
                            </div>

                            <button type="submit" class="btn-gca w-100">
                                <i class="bi bi-journal-plus me-2"></i>Crear Asignatura
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>