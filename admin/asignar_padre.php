<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

require_once "../config/database.php";

$mensaje = "";

/* Obtener padres */
$padres = $conexion->query(
    "SELECT id, nombre FROM usuarios WHERE rol = 'padre' ORDER BY nombre"
)->fetchAll(PDO::FETCH_ASSOC);

/* Obtener estudiantes */
// Nota: Algunos registros pueden estar en la tabla 'usuarios' con rol 'estudiante' o en la tabla 'estudiantes'
// Dependiendo del esquema, aquí asumo la tabla 'estudiantes' según el código previo
$estudiantes = $conexion->query(
    "SELECT id, nombre FROM estudiantes ORDER BY nombre"
)->fetchAll(PDO::FETCH_ASSOC);

/* Procesar formulario */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $padre_id = $_POST["padre_id"];
    $estudiante_id = $_POST["estudiante_id"];

    try {
        $sql = "UPDATE estudiantes SET padre_id = :padre WHERE id = :estudiante";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ":padre" => $padre_id,
            ":estudiante" => $estudiante_id
        ]);
        $mensaje = "Padre asignado correctamente.";
    } catch (PDOException $e) {
        $mensaje = "Error al realizar la asignación.";
    }
}

$pageTitle = "Asignar Padre";
include "includes/header.php";
?>

<body>
    <div id="overlay" onclick="closeSidebar()"></div>

    <?php include "includes/sidebar.php"; ?>

    <main id="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="breadcrumb-bar">
                <h5>Asignar Padre</h5>
                <p>Panel Administrativo &nbsp;/&nbsp; Vinculación Familiar</p>
            </div>
        </div>

        <div class="content-area">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card card-form p-4 p-md-5">

                        <div class="header-box">
                            <img src="../assets/img/logo_gca.png" alt="GCA">
                            <h4>Asignar Padre a Estudiante</h4>
                            <span>Gimnasio Castillo Americano</span>
                        </div>

                        <?php if ($mensaje): ?>
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($mensaje) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Seleccionar Padre</label>
                                <select name="padre_id" class="form-select" required>
                                    <option value="">-- Elija un padre --</option>
                                    <?php foreach ($padres as $p): ?>
                                        <option value="<?= $p["id"] ?>"><?= htmlspecialchars($p["nombre"]) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Seleccionar Estudiante</label>
                                <select name="estudiante_id" class="form-select" required>
                                    <option value="">-- Elija un estudiante --</option>
                                    <?php foreach ($estudiantes as $e): ?>
                                        <option value="<?= $e["id"] ?>"><?= htmlspecialchars($e["nombre"]) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn-gca w-100">
                                <i class="bi bi-person-check me-2"></i>Vincular Padre
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>