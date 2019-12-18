@extends('Panel::layouts/app')

@section('title', Helpers::translate('dashboard', 'Dashboard'))
@section('description', Helpers::translate('dashboard', 'Dashboard'))

@section('content')

    <div class="admin_header">
        <div class="admin_title">
            <h1>{{ Helpers::translate('dashboard', 'Dashboard') }}</h1>
        </div>
    </div>
    <div class="admin_content">
        <billing></billing>
    </div>
 
@endsection
 