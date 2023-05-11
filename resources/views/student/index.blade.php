@extends('layouts.backend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h1 class="card-header fw-bold mb-2">All students</h1>
                    <div class="card-body">
                        @foreach($students as $student)
                            <div class="card p-3 mb-1">
                                <h2>{{$student->first_name}} {{$student->last_name}}</h2>
                                <p>{{$student->email}}</p>
                            </div>
                        @endforeach                         
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection