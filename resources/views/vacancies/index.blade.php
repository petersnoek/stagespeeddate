@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
          @if(isset($company))
            {{$company->first()->name}}
          @else
            Alle
          @endif
            Vacatures
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
          Een overzicht van alle beschikbare vacatures
          @if(isset($company))
            bij {{$company->first()->name}}
          @endif
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">App</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Vacatures
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
    @foreach($vacancies as $vacancy)

      <div class="col-md-6 col-xl-4">
        <a style="color: inherit;" href="{{route('vacancy.details', ['vacancy_id' => $vacancy->id, 'company_id' => $vacancy->company->id])}}">
          <div class="block block-rounded h-100 mb-0 ">
            <div class="bg-gray my-0 block block-rounded">
              <div class="bg-gray block-header w-2 py-0 px-2">
                <div style="max-width: 65%" class="text-truncate" >{{$vacancy->company->name}}</div>
                <div style="float:right; max-width: 30%" class="text-truncate" title="{{$vacancy->company->location}}">{{$vacancy->company->location}}</div>
              </div>
              <div style="border-radius: 0.375rem 0.375rem 0px 0px" class="block-header block-header-default">
                <h3 class="block-title">{{$vacancy->name}}</h3>
              </div>
            </div>
            <div class="block-content px-2 py-2 fs-sm text-muted">
              <p style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 4;" class="px-2 m-0 w-5 text-truncate text-wrap">{{$vacancy->bio}}</p>
            </div>
            <button class="btn btn-sm m-3 btn-alt-secondary d-flex align-items-center" href="{{route('vacancy.details', ['vacancy_id' => $vacancy->id, 'company_id' => $vacancy->company->id])}}">
              Meer info
            </button>
          </div>
        </a>
      </div>
    
    @endforeach
    </div>
  </div>
  <!-- END Page Content -->
@endsection
