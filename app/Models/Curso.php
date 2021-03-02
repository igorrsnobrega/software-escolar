<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Curso extends Model
{
    use HasFactory;

    protected $primaryKey = 'curso_id';

    protected $fillable = [
        'curso_id', 'curso_nome_curso', 'curso_cargaHoraria',  'curso_pq', 'curso_quem', 'curso_recompensa', 'curso_frase', 'imagemCurso1'
    ];
}
