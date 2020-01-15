<?php

namespace App\Http\Controllers;

use App\Entities\Property;
use App\Http\Requests\PropertyRequest;
use App\Repositories\PropertyRepository;
use App\Services\PropertyService;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * @var \App\Services\PropertyService
     */
    private $service;

    /**
     * @var \App\Repositories\PropertyRepository
     */
    private $repository;

    /**
     * @param \App\Services\PropertyService        $service
     * @param \App\Repositories\PropertyRepository $repository
     */
    public function __construct(PropertyService $service, PropertyRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * @param \App\Entities\Property $property
     *
     * @return mixed
     */
    public function read(Property $property)
    {
        $nearby = $property->nearby;

        return view('property.read', compact('property', 'nearby'));
    }

    /**
     * @return mixed
     */
    public function readAll()
    {
        $properties = Auth::user()->properties;

        return view('property.read_all', compact('properties'));
    }

    /**
     * @return mixed
     */
    public function store()
    {
        return view('property.create');
    }

    /**
     * @param \App\Http\Request\PropertyRequest $request
     *
     * @return mixed
     */
    public function create(PropertyRequest $request)
    {
        $property = $this->service->createFromRequest($request);

        return response()->json([
            'errors' => false,
            'property_id' => $property->id,
        ]);
    }

    /**
     * @param \App\Entities\Property $property
     *
     * @return mixed
     */
    public function edit(Property $property)
    {
        return view('property.update', compact('property'));
    }

    /**
     * @param \App\Http\Request\PropertyRequest $request
     * @param \App\Entities\Property            $property
     *
     * @return mixed
     */
    public function update(PropertyRequest $request, Property $property)
    {
        $this->service->updateFromRequest($request, $property);

        return response()->json([
            'erorrs' => false,
            'property_id' => $property->id
        ]);
    }

    /**
     * @param \App\Entities\Property $property
     *
     * @return mixed
     */
    public function delete(Property $property)
    {
        $this->repository->delete($property->id);

        return response()->json([
            'success' => true,
        ]);
    }
}
