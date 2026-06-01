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
    $email = trim($_POST["email"] ?? "");
    $pass1 = $_POST["password"] ?? "";
    $pass2 = $_POST["password2"] ?? "";

    if ($nombre === "" || $email === "" || $pass1 === "" || $pass2 === "") {
        $mensaje = "Todos los campos son obligatorios.";
        $tipo = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo electrónico no es válido.";
        $tipo = "danger";
    } elseif ($pass1 !== $pass2) {
        $mensaje = "Las contraseñas no coinciden.";
        $tipo = "warning";
    } else {
        try {
            $ver = $conexion->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
            $ver->execute([":email" => $email]);

            if ($ver->fetch()) {
                $mensaje = "Este correo ya se encuentra registrado.";
                $tipo = "warning";
            } else {
                $hash = password_hash($pass1, PASSWORD_DEFAULT);

                $sql = "INSERT INTO usuarios (nombre, email, password, rol)
                        VALUES (:nombre, :email, :password, 'profesor')";

                $stmt = $conexion->prepare($sql);
                $stmt->execute([
                    ":nombre" => $nombre,
                    ":email" => $email,
                    ":password" => $hash
                ]);

                $_SESSION["success_msg"] = "Profesor creado correctamente.";
                header("Location: ver_profesores.php");
                exit;
            }
        } catch (PDOException $e) {
            $mensaje = "Error al crear el profesor.";
            $tipo = "danger";
        }
    }
}

$pageTitle = "Crear Profesor";
include "includes/header.php";
?>

<body>
    <div id="overlay" onclick="closeSidebar()"></div>

    <?php include "includes/sidebar.php"; ?>

    <main id="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="breadcrumb-bar">
                <h5>Crear Profesor</h5>
                <p>Panel Administrativo &nbsp;/&nbsp; Nuevo Profesor</p>
            </div>
        </div>

        <div class="content-area">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card card-form p-4 p-md-5">

                        <div class="header-box">
                            <img src="../assets/img/logo_gca.png" alt="GCA">
                            <h4>Registro de Profesor</h4>
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
                                <label class="form-label fw-medium">Nombre completo</label>
                                <input type="text" name="nombre" class="form-control"
                                    value="<?= htmlspecialchars($_POST["nombre"] ?? "") ?>" required
                                    placeholder="Ej. Carlos Mendoza">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Correo electrónico</label>
                                <input type="email" name="email" class="form-control" placeholder="profesor@gca.edu.co"
                                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium">Confirmar contraseña</label>
                                <input type="password" name="password2" class="form-control" required>
                            </div>

                            <button type="submit" class="btn-gca w-100">
                                <i class="bi bi-check-circle me-2"></i>Registrar Profesor
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>