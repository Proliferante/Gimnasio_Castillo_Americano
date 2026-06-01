<?php
require_once "/home/jesusdev/Gimnasio Castillo Americano - Web/colegio_web/colegio_web/config/database.php";
try {
    $stmt = $conexion->query("DESCRIBE cursos");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
