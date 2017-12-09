@extends('layouts.app')

@section('template_title')
	{{ $user->name }}'s Profile
@endsection

@section('template_fastload_css')

	#map-canvas{
		min-height: 300px;
		height: 100%;
		width: 100%;
	}

@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">

						{{ trans('profile.showProfileTitle',['username' => $user->name]) }}

					</div>
					<div class="panel-body">

    					<img src="@if ($user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif" alt="{{ $user->first_name }}" class="user-avatar">

						<dl class="user-info">

							<dt>
								{{ trans('profile.showProfileFirstName') }}
							</dt>
							<dd>
								{{ $user->first_name }}
							</dd>

							@if ($user->last_name)
								<dt>
									{{ trans('profile.showProfileLastName') }}
								</dt>
								<dd>
									{{ $user->last_name }}
								</dd>
							@endif

							<dt>
								{{ trans('profile.showProfileEmail') }}
							</dt>
							<dd>
								{{ $user->email }}
							</dd>

							@if(!empty($user->userable->phone_1))
							<dt>
								Phone no.
							</dt>
							<dd>
								{{ $user->userable->phone_1 }}
							</dd>
							@endif
							@if(!empty($user->userable->phone_2))
							<dt>
								Home no.
							</dt>
							<dd>
								{{ $user->userable->phone_2 }}
							</dd>
							@endif
							@if(!empty($user->hasAddress()))
							<dt>
								Address
							</dt>
							<dd>
								@php $user_address = $user->getPrimaryAddress(); @endphp
								{{ $user_address->line_1 }}<br>
								{{ $user_address->line_2 }}<br>
								{{ $user_address->post_code }}<br>
								{{ $user_address->city }}<br>
								{{ $user_address->state }}<br>
								{{ $user_address->country->name }}
							</dd>
							@endif

						</dl>

						@if ($user->profile)
							@if (Auth::user()->id == $user->id)

								{!! HTML::icon_link(URL::to('/profile/'.Auth::user()->email.'/edit'), 'fa fa-fw fa-cog', trans('titles.editProfile'), array('class' => 'btn btn-small btn-info btn-block')) !!}

							@endif
						@else

							<p>{{ trans('profile.noProfileYet') }}</p>
							{!! HTML::icon_link(URL::to('/profile/'.Auth::user()->email.'/edit'), 'fa fa-fw fa-plus ', trans('titles.createProfile'), array('class' => 'btn btn-small btn-info btn-block')) !!}

						@endif

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('footer_scripts')

	@include('scripts.google-maps-geocode-and-map')

@endsection
