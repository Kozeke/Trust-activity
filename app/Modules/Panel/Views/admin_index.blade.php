@extends('Panel::layouts/admin')

@section('content')

	<div class="admin_header">
	    <div class="admin_title">
	        <h1>Dashboard</h1>
	    </div>
	</div>
	<div class="admin_content">
		<div class="container admin_container">
			<div class="row">
				<div class="col-lg-offset-2 col-lg-8">
					<div class="guide_title">
						<h3>Количество пользователей с активным модулем notifications <b>{{$statistic->count()}}</b></h3>
					</div>		
				</div>
			</div>
		</div>
	</div>
	 
@endsection
