<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CourseClass;
use Illuminate\Auth\Access\HandlesAuthorization;
use Carbon\Carbon;

class CourseClassPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the courseClass.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseClass  $courseClass
     * @return mixed
     */
    public function view(User $user, CourseClass $courseClass)
    {
        //
    }

    /**
     * Determine whether the user can create courseClasses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the courseClass.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseClass  $courseClass
     * @return mixed
     */
    public function update(User $user, CourseClass $courseClass)
    {
        //
    }

    /**
     * Determine whether the user can delete the courseClass.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CourseClass  $courseClass
     * @return mixed
     */
    public function delete(User $user, CourseClass $courseClass)
    {
        //
    }

    public function acceptCourse(User $user, CourseClass $courseClass)
    {
        $pivot = auth()->user()->userable->courseClasses()->find($courseClass->id);

        if(Carbon::now() < $courseClass->date){
          return false;
        }

        return $pivot->pivot->fixed == 0;
    }
}
