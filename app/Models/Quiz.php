<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'passing_score' => 'integer',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function latestAttempt()
    {
        return $this->hasOne(QuizAttempt::class)->latestOfMany();
    }

    /**
     * Relasi ke user yang pernah mengerjakan kuis ini.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'quiz_attempts');
    }
}

