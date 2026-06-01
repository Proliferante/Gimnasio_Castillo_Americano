<?php

namespace App\Models;

use App\Base\Model;

class Usuario extends Model
{
    protected static string $table = 'usuarios';
    protected static string $primaryKey = 'id';
}
