<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nota extends Model
{
    use HasFactory;

    protected $fillable = ['estudiante_id', 'asignatura_id', 'nota'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
}
