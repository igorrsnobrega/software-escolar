<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoModulo extends Model
{
    use HasFactory;

    protected $table = 'cursos_modulos';
    protected $primaryKey = 'controle_id';

}
