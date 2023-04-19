<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table = 'asignaturas';

    use HasFactory;

    // linea para quitar el update at
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_curso',
        'id_profesor',
    ];

    // RELACION PARA SACAR CURSO Y HACER INNER JOIN
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }

    // RELACION PARA SACAR PROFESOR Y HACER INNER JOIN
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'id_profesor');
    }
}
