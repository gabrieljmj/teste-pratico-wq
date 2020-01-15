<?php

namespace App\Policies;

use App\Entities\Property;
use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PropertyPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Entities\User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * @param \App\Entities\User    $user
     * @param \App\Entities\Property $property
     *
     * @return bool
     */
    public function update(User $user, Property $property): bool
    {
        return $this->userOwnsProperty($user, $property);
    }

    /**
     * @param \App\Entities\User    $user
     * @param \App\Entities\Property $property
     *
     * @return bool
     */
    public function delete(User $user, Property $property): bool
    {
        return $this->userOwnsProperty($user, $property);
    }

    /**
     * @param \App\Entities\User    $user
     * @param \App\Entities\Property $property
     *
     * @return bool
     */
    private function userOwnsProperty(User $user, Property $property): bool
    {
        return $user->id === $property->user->id;
    }
}
