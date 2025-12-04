<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected $casts = [
        'score' => 'integer',
        'is_passed' => 'boolean',
    ];

    /**
     * Relasi ke user yang mengerjakan kuis.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke kuis yang dikerjakan.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
