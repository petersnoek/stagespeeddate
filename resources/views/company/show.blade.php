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
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <div class="d-flex">
                        <h1 style="padding: 0.5rem 1rem; padding-left: 0px" class="h3 fw-bold mb-2">
                            {{$company->name}}
                        </h1>
                        <a style="width: fit-content; height: fit-content;" class="form-control form-control-lg form-control-alt @if($company->name == 'New Company')bg-success-light @endif" href="{{route('company.update')}}"><i class="fa fa-pen"></i></a>
                    </div>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{$company->bio}}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Bedrijven
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{$company->name}}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content">
        <div class="block block-rounded px-5 py-3">
            @include('layouts.partials.messages')   
            <div class=" block-content-full">
                <div class="col-sm-8 col-xl-11">
                @if($company->description != null)
                    <h5 style="margin: 0px; " class="p-1">Over ons bedrijf</h5>
                    <div class="p-2">{{$company->description}}</div>
                @else
                    <h5 style="margin: 0px; " class="p-1 text-muted"><i>dit bedrijf heeft nog geen beschrijving</i></h5>
                @endif
                </div>
            </div>
            <div style="border-top: 1px gray solid;" class="pt-3 mt-5 block-content-full">
                <div style="justify-content: space-between;" class="d-flex">
                    <h4 style="padding-left: 0px !important;" class="p-3">Mijn Vacatures</h4>
                    <a style="height: fit-content;" class="btn btn-alt-primary mt-2" href="{{route('vacancy.create')}}">Nieuwe Vacature</a>
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
                                        <a style="width:fit-content; height: fit-content;" class="btn btn-alt-primary" href="{{route('vacancy.application.index', ['vacancy_id' => Hashids::encode($vacancy->id)])}}">{{$vacancy->application_count()}}</a> 
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
        <!-- END Dynamic Table with Export Buttons -->
    </div>
    <!-- END Page Content -->
@endsection

