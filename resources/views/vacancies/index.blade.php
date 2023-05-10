@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            Stage Vacatures
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Welcome {{Auth::user()->first_name}}, everything looks great.
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">App</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Dashboard
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- END Hero -->

  <!-- Page Content -->
  <div class="content">
    <div class="row items-push">
    @foreach($vacancies as $vacancy)

      <div class="col-md-6 col-xl-4">
        <div class="block block-rounded h-100 mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">{{$vacancy->name}}</h3>
          </div>
          <div class="px-4 py-1">
            <p class="my-0 fs-sm">bij {{$vacancy->company->name}}</p>
          </div>
          <div class="block-content px-2 py-2 fs-sm text-muted">
            <p style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;" class="bg-light px-2 m-0 w-5 text-truncate text-wrap">{{$vacancy->bio}}</p>
{{--             <p class="bg-light px-2 m-0 w-5">{{$vacancy->bio . ' ' . strlen($vacancy->bio)}}</p>
 --}}          </div>
        </div>
      </div>
    
    @endforeach
    </div>
  </div>
  <!-- END Page Content -->
@endsection
