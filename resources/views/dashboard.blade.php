@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            Dashboard
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
  @include('layouts.partials.messages')
    <div class="row items-push">
      @foreach($companies as $company)
        <a href="{{ route('company.vacancy.index', ['company_id' => Hashids::encode($company->id)]) }}" class="col-md-6 col-xl-4 mb-4" style="color: initial">
          <div class="block block-rounded h-100">
            <div class="block-header block-header-default">
              <h3 class="block-title">{{$company->name}}</h3>
            </div>
            <div class="text-muted">
              <div style="overflow:hidden; height:11.75rem;" class="position-relative">
                <img class="img-fluid w-100 position-absolute"  style="top: 50%; left: 50%; transform: translate(-50%, -50%); min-height: 11.75rem; min-width: 100%" src="{{$company->image}}" alt="">
              </div>
              <div class="p-3">
                <p class="lh-sm m-0 overflow-hidden">
                  {{$company->bio}}
                </p>
              </div>
            </div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
  <!-- END Page Content -->
@endsection
