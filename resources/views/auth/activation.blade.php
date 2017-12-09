@extends('layouts.app')

@section('template_title')
	{{ Lang::get('titles.activation') }}
@endsection

@section('content')
	<div class="container">
		<div class="row">
			@include('partials.carousell')

			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">{{ Lang::get('titles.activation') }}</div>
					<div class="panel-body">
						<p>{{ Lang::get('auth.regThanks') }}</p>
						@if(auth()->user()->userable->member_status_id == 1)
						<p>Please wait until your membership account has been activate</p>
						@else
						<p>Your application had been rejected, please call us to any inqueries</p>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
