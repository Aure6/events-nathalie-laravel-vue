<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    use HasFactory;

    public function contact()
    {
        return $this->morphOne(Contact::class, 'contactable');
    }
}
