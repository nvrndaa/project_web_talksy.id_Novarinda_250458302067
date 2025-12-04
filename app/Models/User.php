<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /**
     * Relasi ke materi yang telah diselesaikan oleh user.
     */
    public function completions()
    {
        return $this->belongsToMany(Material::class, 'material_completions');
    }

    /**
     * Relasi ke riwayat pengerjaan kuis oleh user.
     */
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Relasi ke sertifikat yang dimiliki oleh user.
     * Seorang user hanya memiliki satu sertifikat kelulusan.
     */
    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    /**
     * Scope a query to only include admin users.
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', UserRole::ADMIN);
    }

    /**
     * Scope a query to only include student users.
     */
    public function scopeStudent($query)
    {
        return $query->where('role', UserRole::STUDENT);
    }
}

