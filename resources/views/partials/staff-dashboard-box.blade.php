<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      App\Models\Member::all()
    ),
    'title' => 'Member',
    'footer_link' => route('members.index'),
  ])
  @endcomponent
</div>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      App\Models\Member::whereHas('user', function ($query) {
          $query->where('activated', 0);
      })->get()
    ),
    'title' => 'Member waiting for approval',
    'footer_link' => route('members.index', ['status' => 0]),
  ])
  @endcomponent
</div>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      App\Models\Member::has('courseClasses', 0)->get()
    ),
    'title' => 'Member do not have course',
    'footer_link' => route('members.index', ['course' => 0]),
  ])
  @endcomponent
</div>

<?php

$member_course = App\Models\Member::whereHas('user', function ($query) {
    $query->where('activated', 1);
})->get();

$member_attend = 0;
$member_not_attend = 0;

foreach ($member_course as $key => $user) {
  if($user->notAttendedCourseClasses->count() > 0){

    $member_not_attend++;

  }else if($user->attendedCourseClasses->count() > 0){

    $member_attend++;

  }
}

?>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => $member_attend,
    'title' => 'Members attend courses',
    'footer_link' => route('members.index', ['attend_course' => 1]),
  ])
  @endcomponent
</div>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => $member_not_attend,
    'title' => 'Members not attend courses',
    'footer_link' => route('members.index', ['attend_course' => 0]),
  ])
  @endcomponent
</div>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      App\Models\CourseClass::all()
    ),
    'title' => 'Courses',
    'footer_link' => route('courses.index'),
  ])
  @endcomponent
</div>
