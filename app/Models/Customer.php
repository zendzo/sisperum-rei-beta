<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    public function province() : HasOne
    {
      return $this->hasOne(Province::class);  
    }

    public function regency(): HasOne
    {
      return $this->hasOne(Regency::class);
    }
}
