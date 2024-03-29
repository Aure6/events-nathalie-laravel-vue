<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company_name', 'email',  'phone'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
