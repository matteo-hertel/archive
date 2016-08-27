@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Your missing number</div>
                <div class="panel-body">
                    <p>Your missing number is: {{$missingNumber}}</p>
                </div>

                <div class="panel-footer"><a href="{{action('TestController@index')}}">Try Again!</a></div>
            </div>
        </div>
    </div>
</div>
@endsection
