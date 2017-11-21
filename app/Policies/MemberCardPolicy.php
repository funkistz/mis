<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MemberCard;
use App\Models\Member;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberCardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the memberCard.
     *
     * @param  \App\Models\User  $user
     * @param  \App\MemberCard  $memberCard
     * @return mixed
     */
    public function view(User $user, MemberCard $memberCard)
    {
        //
    }

    /**
     * Determine whether the user can create memberCards.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $user = auth()->user();

        if($user->userable_type != Member::class)
          return false;

        if(!empty($user->userable->memberCard))
          return false;

        return true;
    }

    /**
     * Determine whether the user can update the memberCard.
     *
     * @param  \App\Models\User  $user
     * @param  \App\MemberCard  $memberCard
     * @return mixed
     */
    public function update(User $user, MemberCard $memberCard)
    {
        //
    }

    /**
     * Determine whether the user can delete the memberCard.
     *
     * @param  \App\Models\User  $user
     * @param  \App\MemberCard  $memberCard
     * @return mixed
     */
    public function delete(User $user, MemberCard $memberCard)
    {
        //
    }
}
