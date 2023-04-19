<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores';

    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'estado',
    ];
    
}
