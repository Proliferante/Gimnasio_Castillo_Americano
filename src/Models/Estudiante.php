<?php

namespace App\Models;

use App\Base\Model;

class Estudiante extends Model
{
    protected static string $table = 'estudiantes';
    protected static string $primaryKey = 'id';
}
