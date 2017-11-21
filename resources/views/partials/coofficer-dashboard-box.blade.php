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
      App\Models\Member::has('coaches', '>' , 0)->get()
    ),
    'title' => 'Member have couch',
    'footer_link' => route('members.index', ['coach' => 1]),
  ])
  @endcomponent
</div>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      App\Models\Member::has('coaches', 0)->get()
    ),
    'title' => 'Member do not have couch',
    'footer_link' => route('members.index', ['coach' => 0]),
  ])
  @endcomponent
</div>
