@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('content')
    <base-login>
        <div v-slot:socialite class="row">
            <div class="col">
                <div class="text-center"> 
                    {!! $socialiteLinks !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </base-login>
@endsection
