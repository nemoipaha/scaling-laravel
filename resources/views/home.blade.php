@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dashboard
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>

            <div class="panel panel-default">
                <process-job></process-job>
            </div>

            <div class="panel panel-default">
                <profile-image profile_image="{{ optional($profileImage)->id }}"/>
            </div>
        </div>
    </div>
</div>
@endsection