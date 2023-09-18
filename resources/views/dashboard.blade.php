@section('css')
  <!-- Page JS Plugins CSS -->
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection

@section('js')
  <!-- jQuery (required for DataTables plugin) -->
  <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

  <!-- Page JS Plugins -->
  <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

  <!-- Page JS Code -->
  {{-- @vite(['resources/js/pages/datatables.js']) --}}
  <script type="module" src="{{ asset('build/assets/datatables-ad71b457.js') }}"></script>
@endsection

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
            Welkom {{Auth::user()->first_name}}, @if(Auth::user()->role != 'company')hier is een overzicht van alle bedrijven.@else hier is een overzicht van all uw vacatures @endif
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
    @if(Auth::user()->role != 'company')
    <div class="row items-push">
      @foreach($companies as $company)
        <a href="{{ route('company.vacancy.index', ['company_id' => Hashids::encode($company->id)]) }}" class="col-md-6 col-xl-4 mb-4" style="color: initial">
          <div class="block block-rounded h-100">
            <div class="block-header block-header-default">
              <h3 style="max-width: 100%" class="block-title text-truncate" title="{{$company->name}}">{{$company->name}}</h3>
            </div>
            <div style="border-bottom: 1px whitesmoke solid;" class="px-3 d-flex justify-content-end text-muted">
              <small><i>{{$company->location}}</i></small>
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
    @else
      <div class="block block-rounded">
      <div class="px-5 py-3 block-content-full">
          <div style="justify-content: space-between;" class="d-flex">
              <h4 style="padding-left: 0px !important;" class="p-3">Mijn Vacatures</h4>
              <a style="height: fit-content;" class="btn btn-alt-primary mt-2" href="{{route('vacancy.create', ['company_id' => Hashids::encode(Auth::user()->company->id)])}}">Nieuwe Vacature</a>
          </div>
          <div>
              <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm">
                  <thead>
                      <tr>
                      <th>Naam</th>
                      <th>Aanmeldingen</th>
                      <th style="width: 15%;">Status</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach(Auth::user()->company->vacancies as $vacancy)
                      <tr>
                          <td class="fw-semibold">
                          <div>{{$vacancy->name}}</div>
                          </td>
                          <td class="d-none d-sm-table-cell">
                              <span class="text-muted">
                              @if($vacancy->application_count() == 0)
                                  nog geen aanmeldingen
                              @else 
                                  <a style="width:fit-content; height: fit-content;" class="btn btn-alt-primary" href="{{route('vacancy.application.index', ['company_id' => Hashids::encode(Auth::user()->company->id), 'vacancy_id' => Hashids::encode($vacancy->id)])}}">{{$vacancy->application_count()}}</a> 
                              @endif 
                              </span>
                          </td>
                          <td class="text-muted">
                          {{$vacancy->availability()}}
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
      </div>
    @endif
  </div>
  <!-- END Page Content -->
@endsection
