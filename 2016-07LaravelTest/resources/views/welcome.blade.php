@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Welcome!</h2>
            <p>Please click <a href="{{action('TestController@index')}}">here</a> to get started</p>
        </div>
    </div>
</div>
@endsection
