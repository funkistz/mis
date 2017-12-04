<?php

namespace App\Providers;
use App\Models\MemberCard;
use App\Models\Member;
use App\Models\Course;
use App\Models\CourseClass;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        MemberCard::class => 'App\Policies\MemberCardPolicy',
        Member::class => 'App\Policies\MemberPolicy',
        Course::class => 'App\Policies\CoursePolicy',
        CourseClass::class => 'App\Policies\CourseClassPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
