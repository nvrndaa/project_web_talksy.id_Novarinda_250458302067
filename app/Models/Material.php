<?php

namespace App\Models;

use App\Enums\MaterialType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => MaterialType::class,
    ];

    /**
     * Relasi ke modul induk.
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Relasi ke user yang telah menyelesaikan materi ini.
     */
    public function completedByUsers()
    {
        return $this->belongsToMany(User::class, 'material_completions');
    }

    /**
     * Relasi ke record penyelesaian materi.
     */
    public function completions()
    {
        return $this->hasMany(MaterialCompletion::class);
    }
}
