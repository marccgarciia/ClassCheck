<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    use HasFactory;

    // linea para quitar el update at
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'promocion',
        'id_escuela',
    ];

    // RELACION PARA SACAR ESCUELA Y HACER INNER JOIN
    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela');
    }
    
    // RELACION PARA SACAR CURSOS EN ALUMNOS
    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }

}