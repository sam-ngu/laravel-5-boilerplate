@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content')

    <frontend-dashboard session="{{json_encode(array_only(session()->all(), ['admin_user_id', 'admin_user_name', 'temp_user_id']) )}}">
    </frontend-dashboard>

@endsection
