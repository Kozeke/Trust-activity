@extends('Panel::layouts/admin')

@section('content')


    <div class="admin_header">
        <div class="admin_title">
            <h1>Users</h1>
        </div>
    </div>
    <div class="admin_breadcrumbs">
        <ul class="breadcrumbs_list">
            <li class="breadcrumbs_item"><a href="/admin/users/" class="breadcrumbs_link">Users</a></li>
        </ul>
    </div>
    <div class="admin_content">
    	<div class="container admin_container" id="admin_app">
    		<users></users>
    	</div>


    </div>


@endsection
