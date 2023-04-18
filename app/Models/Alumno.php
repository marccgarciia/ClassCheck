<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';

    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'email_padre',
        'estado',
        'id_curso',
    ];
    // RELACION PARA SACAR CURSO Y HACER INNER JOIN
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }
}
