@extends('layouts.backend')

@section('content')

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Aanmelding op {{$application->vacancy->name}}
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{$application->vacancy->company->name}}
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="{{route('company.application.index' , ['company_id' => Hashids::encode(Auth::user()->company->id)])}}">Aanmeldingen</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                          {{Hashids::encode($application->id)}}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content px-8">
        <div class="block block-rounded px-5 py-3">
            @include('layouts.partials.messages')
            <div class="block-content block-content-full pb-0 d-flex justify-content-center">
                <div class="col-sm-9 col-xl-3">
                    <img style="width: 8rem; height: 8rem;" src="{{asset($application->student->user->profilePicture)}}">
                </div>
                <div class="col-sm-9 col-xl-9">
                    <h2>{{$application->student->user->fullname()}}</h2>
                    <div class="d-flex">
                      <label class='p-2'>CV:</label>
                      <div>
                      @if($application->student->CV != null)               
                        <a type="text" style="width: 200px" class="form-control form-control-lg form-control-alt text-truncate" href="{{ route('student.downloadCv', ['student_id' => Hashids::encode($application->student->id)]) }}"> {{  explode(',', explode('/', $application->student->CV)[1])[1] }} </a>
                      @else
                        <p class="p-2">N/A</p>
                      @endif
                      </div>
                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
              <label>Motivatie:</label>
                <div class="col-sm-9 col-xl-8 form-control form-control-lg  form-control-alt">
                    {{$application->comment}}
                </div>
            </div>
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    </div>
    <!-- END Page Content -->
@endsection

