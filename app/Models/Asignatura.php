<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asignatura extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'curso'];

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'notas')->withPivot('nota')->withTimestamps();
    }
}
