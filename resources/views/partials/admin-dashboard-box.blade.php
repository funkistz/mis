<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      App\Models\User::whereHas('roles', function ($query) {
          $query->where('slug', 'officer');
      })->get()
    ),
    'title' => 'Officer',
    'footer_link' => route('users', ['role' => 'officer']),
  ])
  @endcomponent
</div>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      App\Models\User::whereHas('roles', function ($query) {
          $query->where('slug', 'staff');
      })->get()
    ),
    'title' => 'Staff',
    'footer_link' => route('users', ['role' => 'staff']),
  ])
  @endcomponent
</div>

<div class="col-md-4">
  @component('partials.dashboard-box',[
    'value' => count(
      App\Models\User::whereHas('roles', function ($query) {
          $query->where('slug', 'coofficer');
      })->get()
    ),
    'title' => 'Cocurriculum Officer',
    'footer_link' => route('users', ['role' => 'coofficer']),
  ])
  @endcomponent
</div>
