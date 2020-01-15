<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Repositories\PropertyRepository;

class PropertySearchController extends Controller
{
    /**
     * @return mixed
     */
    public function search()
    {
        return view('property.search');
    }

    /**
     * @param \App\Http\Requests\SearchRequest     $request
     * @param \App\Repositories\PropertyRepository $repository
     *
     * @return mixed
     */
    public function searchNear(SearchRequest $request, PropertyRepository $repository)
    {
        [$latitude, $longitude, $distance] = array_values($request->only(['latitude', 'longitude', 'distance']));

        $properties = $repository->findByNearCoordinates($latitude, $longitude, $distance);

        return response()->json([
            'result' => $properties->toArray(),
        ]);
    }
}
