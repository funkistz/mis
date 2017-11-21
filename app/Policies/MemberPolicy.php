<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Member;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Member  $member
     * @return mixed
     */
    public function view(User $user, Member $member)
    {
        //
    }

    /**
     * Determine whether the user can create members.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Member  $member
     * @return mixed
     */
    public function update(User $user, Member $member)
    {
        //
    }

    /**
     * Determine whether the user can delete the member.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Member  $member
     * @return mixed
     */
    public function delete(User $user, Member $member)
    {
        //
    }
}
