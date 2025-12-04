<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke materi-materi di dalam modul ini.
     */
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Relasi ke kuis-kuis di dalam modul ini.
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Relasi ke SATU kuis di dalam modul ini (asumsi per modul hanya ada 1 kuis).
     */
    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }
}
