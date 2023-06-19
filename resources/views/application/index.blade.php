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
          <h1 class="h3 fw-bold mb-2">
            Aanmeldingen bij {{$applications->first()->vacancy->name}}
          </h1>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{Route('home')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Vacatures
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Aanmeldingen
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- END Hero -->

  <!-- Page Content -->
  <div class="content">

    <!-- Dynamic Table Full -->
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">
          Dynamic Table <small>Full</small>
        </h3>
      </div>
      <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm">
          <thead>
            <tr>
              <th class="text-center sorting_asc_disabled sorting_desc_disabled" style="width: 80px;"></th>
              <th>Name</th>
              <th>CV</th>
              <th style="width: fit-content">Control</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($applications as $application)
              <tr>
                <td class="fw-semibold d-flex justify-content-center">
                  <img style="width: 60px; height: 60px" src="{{asset($application->student->user->profilePicture)}}" alt="profile picture">
                </td>
                <td class="fw-semibold">
                  <div href="javascript:void(0)">{{$application->student->user->fullname()}}</div>
                </td>
                <td class="text-muted">
                @if($application->student->CV != null)               
                  <a type="text" style="width: 200px" class="form-control form-control-lg form-control-alt text-truncate" href="{{ route('student.downloadCv', ['student_id' => Hashids::encode($application->student->id)]) }}"> {{  explode(',', explode('/', $application->student->CV)[1])[1] }} </a>
                @else
                  N/A
                @endif
                </td>
                <td>
                  <div style="width: fit-content; height: fit-content;" class="form-control form-control-lg form-control-alt">
                    <i class="fa fa-reply"></i>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- END Dynamic Table Full -->

  </div>
  <!-- END Page Content -->
@endsection
