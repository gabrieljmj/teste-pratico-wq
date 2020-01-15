<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['address', 'number', 'district', 'complement', 'property_id', 'city', 'state', 'zip_code'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
