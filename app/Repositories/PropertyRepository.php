<?php

namespace App\Repositories;

use App\Entities\Property;
use Prettus\Repository\Eloquent\BaseRepository;

class PropertyRepository extends BaseRepository
{
    public function model()
    {
        return Property::class;
    }

    /**
     * @param string $latitude
     * @param string $longitude
     * @param float  $distance  in kilometers
     *
     * @return mixed
     */
    public function findByNearCoordinates($latitude, $longitude, $distance, ?int $limit = null)
    {
        $query = $this->model
            ->whereRaw("(
                (
                    acos(
                        sin(( ${latitude} * pi() / 180))
                        * sin(( latitude * pi() / 180))
                        + cos(( ${latitude} * pi() /180 ))
                        * cos(( latitude * pi() / 180))
                        * cos((( ${longitude} - longitude ) * pi()/180))
                    ) * 180/pi()
                ) * 60 * 1.1515 * 1.609344
            ) <= ?", $distance)
        ;

        if ($limit) {
            $query = $query->limit($limit);
        }

        return $query->get();
    }
}
