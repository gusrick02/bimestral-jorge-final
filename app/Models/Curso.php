<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['nome', 'descricao'];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function alunos()
    {
        return $this->hasMany(Aluno::class); 
    }
}
