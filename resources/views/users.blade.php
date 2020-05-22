@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users</div>
                    @foreach($users as $user)
                        <div class="card-body">
                            <a style="display: block; text-decoration: none;" href="{{ route('conversations', $user->id) }}">
                                {{ $user->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
