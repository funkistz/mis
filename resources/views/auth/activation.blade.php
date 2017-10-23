@extends('layouts.app')

@section('template_title')
	{{ Lang::get('titles.activation') }}
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">{{ Lang::get('titles.activation') }}</div>
					<div class="panel-body">
						<p>{{ Lang::get('auth.regThanks') }}</p>
						<p>Please wait until your membership account has been activate</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
