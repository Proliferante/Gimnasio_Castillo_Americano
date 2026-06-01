<?php
require_once "/home/jesusdev/Gimnasio Castillo Americano - Web/colegio_web/colegio_web/config/database.php";
try {
    $stmtCursos = $conexion->query("SELECT * FROM cursos ORDER BY nombre");
    print_r($stmtCursos->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
