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
      App\Models\Member::has('courses', 0)->get()
    ),
    'title' => 'Member do not have course',
    'footer_link' => route('members.index', ['course' => 0]),
  ])
  @endcomponent
</div>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      \DB::table('course_member')->where('accepted', 1)->get()
    ),
    'title' => 'Members attend courses',
    'footer_link' => route('members.index', ['course' => 0]),
  ])
  @endcomponent
</div>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      \DB::table('course_member')->where('accepted', 0)->get()
    ),
    'title' => 'Members not attend courses',
    'footer_link' => route('members.index', ['course' => 0]),
  ])
  @endcomponent
</div>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      App\Models\Course::all()
    ),
    'title' => 'Courses',
    'footer_link' => route('courses.index'),
  ])
  @endcomponent
</div>
