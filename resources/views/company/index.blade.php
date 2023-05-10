@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h1 class="card-header fw-bold mb-2">All companies</h1>
                    <div class="card-body">
                        @foreach($companies as $company)
                            <div class="card p-3 mb-1">
                                <h2>{{$company->name}}</h2>
                                <p>{{$company->bio}}</p>
                            </div>
                        @endforeach                         
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection