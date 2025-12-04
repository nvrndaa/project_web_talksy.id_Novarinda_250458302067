<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MaterialCompletion extends Pivot
{
    protected $table = 'material_completions';

    // Karena kita tidak menggunakan ID auto-increment
    public $incrementing = false;
    
    // Definisikan composite primary key
    protected $primaryKey = ['user_id', 'material_id'];

    // Pivot table biasanya tidak memiliki timestamps `updated_at`
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
