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
    header("Location: ver_cursos.php");
    exit;
}

$id = $_GET["id"];

$stmt = $conexion->prepare("SELECT id, nombre, grado FROM cursos WHERE id = :id");
$stmt->execute([":id" => $id]);
$curso = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$curso) {
    header("Location: ver_cursos.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $grado = trim($_POST["grado"] ?? "");

    if ($nombre === "" || $grado === "") {
        $mensaje = "Todos los campos son obligatorios.";
        $tipo = "danger";
    } else {
        try {
            $sql = "UPDATE cursos SET nombre = :nombre, grado = :grado WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([":nombre" => $nombre, ":grado" => $grado, ":id" => $id]);

            $_SESSION["success_msg"] = "Curso actualizado correctamente.";
            header("Location: ver_cursos.php");
            exit;
        } catch (PDOException $e) {
            $mensaje = "Error al actualizar el curso.";
            $tipo = "danger";
        }
    }
}

$pageTitle = "Editar Curso";
include "includes/header.php";
?>

<body>
    <div id="overlay" onclick="closeSidebar()"></div>

    <?php include "includes/sidebar.php"; ?>

    <main id="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="breadcrumb-bar">
                <h5>Editar Curso</h5>
                <p>Panel Administrativo &nbsp;/&nbsp; Editar Curso</p>
            </div>
        </div>

        <div class="content-area">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card card-form p-4 p-md-5">

                        <div class="header-box">
                            <img src="../assets/img/logo_gca.png" alt="GCA">
                            <h4>Editar Curso</h4>
                            <span>Gimnasio Castillo Americano</span>
                        </div>

                        <?php if ($mensaje): ?>
                            <div class="alert alert-<?= $tipo ?> alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($mensaje) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Grado</label>
                                <select name="grado" class="form-select" required>
                                    <option value="">Seleccione</option>
                                    <option value="sexto" <?= ($_POST["grado"] ?? $curso["grado"]) == "sexto" ? "selected" : "" ?>>Sexto</option>
                                    <option value="septimo" <?= ($_POST["grado"] ?? $curso["grado"]) == "septimo" ? "selected" : "" ?>>Séptimo</option>
                                    <option value="octavo" <?= ($_POST["grado"] ?? $curso["grado"]) == "octavo" ? "selected" : "" ?>>Octavo</option>
                                    <option value="noveno" <?= ($_POST["grado"] ?? $curso["grado"]) == "noveno" ? "selected" : "" ?>>Noveno</option>
                                    <option value="decimo" <?= ($_POST["grado"] ?? $curso["grado"]) == "decimo" ? "selected" : "" ?>>Décimo</option>
                                    <option value="once" <?= ($_POST["grado"] ?? $curso["grado"]) == "once" ? "selected" : "" ?>>Once</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Nombre del curso (ej. A, B)</label>
                                <input type="text" name="nombre" class="form-control"
                                    value="<?= htmlspecialchars($_POST["nombre"] ?? $curso["nombre"]) ?>" required
                                    placeholder="Ej. A">
                            </div>

                            <button type="submit" class="btn-gca w-100">
                                <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                            </button>

                            <a href="ver_cursos.php" class="btn-outline-gca w-100 justify-content-center mt-2">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>
