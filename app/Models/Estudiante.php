<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellidos', 'edad'];

    
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

    
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'notas')->withPivot('nota')->withTimestamps();
    }
}
