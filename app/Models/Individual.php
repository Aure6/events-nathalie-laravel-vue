<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Individual extends Model
{
    use HasFactory;

    public function contact()
    {
        return $this->morphOne(Contact::class, 'contactable');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
