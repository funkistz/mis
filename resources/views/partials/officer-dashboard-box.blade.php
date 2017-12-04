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
          $query->where('activated', 1);
      })->get()
    ),
    'title' => 'Registered Member',
    'footer_link' => route('members.index', ['status' => 1]),
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
