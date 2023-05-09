<?php

namespace App\Models;

// MUST VERIFY TENER CUIDADO
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;


class Alumno extends Model implements Authenticatable
{
    protected $table = 'alumnos';

    use HasFactory;

    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'email',
        'token',
        'password',
        'email_padre',
        'estado',
        'id_curso',
    ];

    protected $hidden = [
        'password',
        'token',
    ];
    
    
    // RELACION PARA SACAR CURSO Y HACER INNER JOIN
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso');
    }


    //::::::::::::::::::::::::::::::::::::::::::::::::::::::

    protected $casts = [
        'estado' => 'boolean',
        'token',
    ];




        /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the remember token for the user.
     *
     * @return string|null
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the remember token for the user.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
