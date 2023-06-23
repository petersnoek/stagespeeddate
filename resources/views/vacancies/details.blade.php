@extends('layouts.backend')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            Vacature details
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            {{$vacancy->bio}}
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{route('home')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{route('vacancy.details', ['vacancy_id' => Hashids::encode($vacancy->id)])}}">Vacature details</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
<!-- end of header -->

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded px-5 py-3">
        <div class="block-content block-content-full">
        @include('layouts.partials.messages')
            <div class="d-flex justify-content-evenly">
                <div class="col-sm-8 col-xl-6">
                    <div class="mb-4">
                        <h2 type="text" class="bold"> {{$vacancy->name}} </h2>
                    </div>
                    <div class="mb-4">
                        <h5 for="">Beschrijving</h5>
                        <p type="text" class="form-control form-control-lg form-control-alt py-3"> {{$vacancy->description}}</p>
                    </div>
                    <!-- @if($vacancy->available == 1)
                        <p type="text" class="form-control muted form-control-lg form-control-alt py-3">Beschikbaar</p>
                    @else
                        <p type="text" class="form-control form-control-lg form-control-alt py-3">Niet Beschikbaar</p>
                    @endif -->
                    @if(Auth::user()->role == "student" && $vacancy->available == 1)
                        <button class="btn btn-sm p-2 btn-alt-secondary d-flex align-items-center"><a style="color:black" href="{{route('application.create', ['vacancy_id' => Hashids::encode($vacancy->id)])}}">Aanmelden</a></button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END Dynamic Table with Export Buttons -->
</div>
@endsection