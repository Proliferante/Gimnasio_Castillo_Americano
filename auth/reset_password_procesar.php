<?php
require_once "../config/database.php";

$token = $_POST["token"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

/* Validar token */
$sql = "
    SELECT id 
    FROM usuarios 
    WHERE reset_token = :token 
    AND reset_expires > NOW()
";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(":token", $token);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Token inválido");
}

/* Actualizar contraseña */
$sql = "
    UPDATE usuarios 
    SET password = :password,
        reset_token = NULL,
        reset_expira = NULL
    WHERE id = :id
";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(":password", $password);
$stmt->bindParam(":id", $usuario["id"]);
$stmt->execute();

header("Location: ../login.php?reset=1");
exit;
