<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Publication;

class Exemplary extends Model
{
    protected $fillable = [
        'status', 'publication_id',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function publication()
    {
        return $this->belongsTo(Publication::class);
    }
}
