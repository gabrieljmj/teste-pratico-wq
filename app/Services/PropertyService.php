<?php

namespace App\Services;

use App\Entities\Property;
use App\Http\Requests\PropertyRequest;
use App\Repositories\AddressRepository;
use App\Repositories\PropertyRepository;
use Illuminate\Support\Facades\Auth;

class PropertyService
{
    /**
     * @var \App\Repositories\PropertyRepository
     */
    private $repository;

    /**
     * @var \App\Repositories\AddressRepository
     */
    private $addressRepository;

    /**
     * @param \App\Repositories\PropertyRepository $repository
     * @param \App\Repositories\AddressRepository  $addressRepository
     */
    public function __construct(PropertyRepository $repository, AddressRepository $addressRepository)
    {
        $this->repository = $repository;
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param \App\Http\Requests\PropertyRequest $request
     *
     * @return \App\Entities\Property
     */
    public function createFromRequest(PropertyRequest $request): Property
    {
        $data = $this->getPropertyData($request);
        $data['user_id'] = Auth::id();
        $property = $this->repository->create($data);

        $addressData = $request->address;
        $addressData['zip_code'] = str_replace('-', '', $addressData['zip_code']);
        $addressData['property_id'] = $property->id;
        $this->addressRepository->create($addressData);

        return $property;
    }

    /**
     * @param \App\Http\Requests\PropertyRequest $request
     * @param \App\Entities\Property             $property
     *
     * @return \App\Entities\Property
     */
    public function updateFromRequest(PropertyRequest $request, Property $property): Property
    {
        $data = $this->getPropertyData($request);
        $property = $this->repository->update($data, $property->id);

        $this->addressRepository->update($request->address, $property->address->id);

        return $property;
    }

    /**
     * @param \App\Http\Requests\PropertyRequest $request
     *
     * @return array
     */
    private function getPropertyData(PropertyRequest $request): array
    {
        $data = $request->property;

        if ($picture = $request->file('property.picture')) {
            $data['picture'] = substr($picture->store('public/photos'), 7);
        }

        return $data;
    }
}
