<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
      'province_id',
      'regency_id',
      'district_id',
      'village_id',
      'name',
      'id_number',
      'pob',
      'dob',
      'address',
      'email',
      'phone',
    ];

    public function province(): BelongsTo
    {
      return $this->belongsTo(Province::class);
    }

    public function regency(): BelongsTo
    {
      return $this->belongsTo(Regency::class);
    }

    public function company(): BelongsTo
    {
      return $this->belongsTo(Company::class);
    }
}
