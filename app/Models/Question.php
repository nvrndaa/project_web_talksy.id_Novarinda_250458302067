<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'options' => 'array',
        'correct_option_index' => 'integer',
    ];

    /**
     * Relasi ke kuis induk.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
