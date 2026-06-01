<?php

/**
 * Archivo de inicialización para páginas legacy.
 * Reemplaza:
 *   session_start();
 *   require_once "../config/database.php";
 *
 * Uso:
 *   require_once __DIR__ . '/../includes/init.php';
 *   checkRole('admin');
 *   // $db ya está disponible como App\Base\Database::getInstance()
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Base\Session;
use App\Base\Auth;
use App\Base\Database;

Session::start();

/**
 * Verifica que el usuario tenga el rol requerido.
 * Redirige al login si no está autenticado o no tiene permisos.
 */
function checkRole(string ...$roles): void
{
    Auth::requireRole($roles);
}

/**
 * Helper: devuelve el nombre del usuario actual.
 */
function userName(): string
{
    return Auth::name() ?? '';
}

/**
 * Helper: devuelve el ID del usuario actual.
 */
function userId(): ?int
{
    return Auth::id();
}

/**
 * Helper: devuelve el rol del usuario actual.
 */
function userRole(): ?string
{
    return Auth::role();
}

/**
 * Helper corto para usar Database singleton en páginas legacy.
 */
function db(): Database
{
    return Database::getInstance();
}

/**
 * Compatibilidad backward: expone $conexion para páginas que lo usan.
 * Cualquier mod future debe migrar a db().
 */
$conexion = Database::connection();
