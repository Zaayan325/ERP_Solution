<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShopPolicy
{
    /**
     * Determine if the given shop can be updated by the user.
     */
    public function update(User $user, Shop $shop)
    {
        return $user->id === $shop->owner_id;
    }

    /**
     * Determine if the given shop can be deleted by the user.
     */
    public function delete(User $user, Shop $shop)
    {
        return $user->id === $shop->owner_id;
    }
}