<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = ['name', 'organizer_id', 'body', 'description', 'start', 'end', 'place'];

    use HasFactory;

    public function comments(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }
}
