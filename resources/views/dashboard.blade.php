@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-center">Welcome to the dashboard page, {{ Auth::user()->username }}!</p>
                    
                    <hr>

                    <div class="text-center">
                        <h2 style="text-decoration: underline">Database Information Check</h2>
                        
                        @if (count(Auth::User()::all()) == 1)
                            <p>Below is a table of 1 user currently created and stored in the database</p>
                        @else
                            <p>Below is a table of {{ count(Auth::User()::all()) }} users currently created and stored in the database</p>
                        @endif

                        <table class="table text-center">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">URL</th>
                                <th scope="col">Date of Birth</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach (Auth::User()::all() as $user)
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        @if (!empty($user->url))
                                            <td>{{ $user->url }}</td>

                                        @else
                                            <td>N/A</td>
                                        @endif

                                        <td>{{ date('d/m/Y', strtotime($user->dob)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <a class="btn btn-primary" href="{{ route('logout') }}" 
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        Click here to log off</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
