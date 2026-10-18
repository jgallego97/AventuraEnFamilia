<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'province'];

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function trails(): HasMany
    {
        return $this->hasMany(Trail::class);
    }
}
