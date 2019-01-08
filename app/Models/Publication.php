<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Exemplary;

class Publication extends Model
{
    protected $fillable = [
        'title', 'author', 'image', 'publication_year', 'type',
    ];

    public function exemplaries()
    {
        return $this->hasMany(Exemplary::class);
    }
}
