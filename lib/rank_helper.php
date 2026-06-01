<?php

function obtenerRankingCurso($conexion, $curso_id, $periodo)
{
    $stmt = $conexion->prepare("
        SELECT e.id, e.nombre, ROUND(AVG(n.nota), 1) as promedio
        FROM estudiantes e
        JOIN notas n ON e.id = n.estudiante_id
        WHERE e.curso_id = ? AND n.periodo = ?
        GROUP BY e.id
        ORDER BY promedio DESC
    ");
    $stmt->execute([$curso_id, $periodo]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function calcularPuestoCurso($conexion, $estudiante_id, $periodo)
{
    $curso_id = obtenerCursoIdEstudiante($conexion, $estudiante_id);
    if (!$curso_id) return null;

    $ranking = obtenerRankingCurso($conexion, $curso_id, $periodo);
    if (empty($ranking)) return null;

    $total = count($ranking);
    $position = 0;
    foreach ($ranking as $i => $r) {
        if ((int)$r['id'] === (int)$estudiante_id) {
            $position = $i + 1;
            break;
        }
    }

    if ($position === 0) return null;
    return "$position/$total";
}

function obtenerCursoIdEstudiante($conexion, $estudiante_id)
{
    $stmt = $conexion->prepare("SELECT curso_id FROM estudiantes WHERE id = ?");
    $stmt->execute([$estudiante_id]);
    $est = $stmt->fetch(PDO::FETCH_ASSOC);
    return $est ? $est['curso_id'] : null;
}

function calcularPromedioGeneralEstudiante($conexion, $estudiante_id, $periodo)
{
    $stmt = $conexion->prepare("
        SELECT ROUND(AVG(nota), 1) as promedio
        FROM notas
        WHERE estudiante_id = ? AND periodo = ?
    ");
    $stmt->execute([$estudiante_id, $periodo]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['promedio'] : null;
}

function calcularMejoresPorGrado($conexion, $periodo, $limite = 5)
{
    $stmt = $conexion->prepare("
        SELECT DISTINCT c.grado
        FROM cursos c
        JOIN estudiantes e ON e.curso_id = c.id
        JOIN notas n ON n.estudiante_id = e.id AND n.periodo = ?
        ORDER BY FIELD(c.grado,
            'maternal','prejardin','jardin','transicion',
            'primero','segundo','tercero','cuarto','quinto',
            'sexto','septimo','octavo','noveno','decimo','undecimo')
    ");
    $stmt->execute([$periodo]);
    $grados = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $resultados = [];
    foreach ($grados as $grado) {
        $stmt = $conexion->prepare("
            SELECT e.id, e.nombre, c.grado, c.nombre as curso_nombre, c.nivel,
                   ROUND(AVG(n.nota), 1) as promedio
            FROM estudiantes e
            JOIN cursos c ON e.curso_id = c.id
            JOIN notas n ON n.estudiante_id = e.id AND n.periodo = ?
            WHERE c.grado = ?
            GROUP BY e.id
            ORDER BY promedio DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $periodo, PDO::PARAM_STR);
        $stmt->bindValue(2, $grado, PDO::PARAM_STR);
        $stmt->bindValue(3, (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        $resultados[$grado] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $resultados;
}

function obtenerNivelGrado($grado)
{
    $preescolar = ['maternal', 'prejardin', 'jardin', 'transicion'];
    $primaria   = ['primero', 'segundo', 'tercero', 'cuarto', 'quinto'];

    $g = mb_strtolower(trim($grado));
    if (in_array($g, $preescolar)) return 'Preescolar';
    if (in_array($g, $primaria))   return 'Primaria';
    return 'Secundaria';
}
