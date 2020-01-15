<?php

namespace App\Entities;

use App\Repositories\PropertyRepository;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['title', 'picture', 'description', 'rent', 'user_id', 'latitude', 'longitude'];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNearbyAttribute()
    {
        /** @var \App\Repositories\PropertyRepository */
        $repository = app(PropertyRepository::class);

        return $repository
            ->findByNearCoordinates($this->latitude, $this->longitude, config('app.nearby_distance'))
            ->filter(function (Property $property) {
                return $property->id !== $this->id;
            })
        ;
    }

    public function toArray()
    {
        $data = parent::toArray();

        $data['address'] = $this->address->toArray();

        return $data;
    }
}
