@extends('layouts.backend')

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

@section('content')

    <!-- Hero -->
    
    <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item" style="padding-left: 600px;">
                <a class="link-fx" href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item" style="padding-left: 15px;">
                Bedrijven
            </li>
            <li class="breadcrumb-item text-end" aria-current="page">
                {{$company->name}}
            </li>
        </ol>
    </nav>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <div class="d-flex flex-row-reverse bd-highlight">
                    </div>
                    <div class="d-flex bd-highlight align-items-start">
                        <div class="p-2 bd-highlight">
                            <img src="{{ asset($company->image) }}" alt="Company Image" width="100" height="100" style="border-radius: 50%;">
                        </div>
                        <div class="p-2 flex-grow-1 bd-highlight">
                            <h1 style="padding: 0.5rem 1rem; padding-left: 10px" class="h3 fw-bold mb-2">
                            {{$company->name}}
                            </h1>
                        </div>
                        <div class="p-2 bd-highlight">
                            <a style="width: fit-content; height: fit-content;" class="form-control form-control-lg form-control-alt @if($company->name == 'New Company')bg-success-light @endif" href="{{route('company.update', ['company_id' => Hashids::encode(Auth::user()->company->id)])}}"><i class="fa fa-pen"></i></a>
                        </div>
                    </div>
                    <div class="flex-grow-1 bd-highlight">
                        <h6 style="padding-left: 133px; font-size: 12px; margin-top: -70px;" class="mb-2">
                            <em>{{$company->location}}</em>
                        </h6>
                    </div>
                    <div class="flex-grow-1 bd-highlight">
                        <h2 style="padding-bottom: 20px; padding-top: 10px; padding-left: 133px;" class="fs-base lh-base fw-medium text-muted mb-0">
                            {{$company->bio}}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content">
        <div class="block block-rounded px-5 py-3">
            <!-- @include('layouts.partials.messages')   
            <div class=" block-content-full">
                <div class="col-sm-8 col-xl-11">
                @if($company->description != null)
                    <h5 style="margin: 0px; " class="p-1">Over ons bedrijf</h5>
                    <div class="p-2">{{$company->description}}</div>
                @else
                    <h5 style="margin: 0px; " class="p-1 text-muted"><i>dit bedrijf heeft nog geen beschrijving</i></h5>
                @endif
                </div>
            </div> -->
            <!-- <div style="border-top: 1px gray solid;" class="pt-3 mt-5 block-content-full"> -->
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
                            <th>Niveau</th>
                            <th style="width: 15%;">Status</th>
                            <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($company->vacancies as $vacancy)
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
                                <td class="fw-semibold">
                                    <span class="text-muted">
                                        {{$vacancy->niveau}}
                                    </span>
                                </td>
                                <td class="text-muted">
                                {{$vacancy->availability()}}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('vacancy.edit', ['company_id' => $vacancy->company_id, 'vacancy_id' => $vacancy->id]) }}" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </a> 
                                        <a class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete" href="{{ route('vacancy.delete', ['company_id' => $vacancy->company_id, 'vacancy_id' => $vacancy->id]) }}" onclick="return confirm('Are you sure you want to delete this vacancy?')">
                                            <i class="fa fa-fw fa-times"></i>    
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            <!-- </div> -->
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    </div>
    <!-- END Page Content -->
@endsection

