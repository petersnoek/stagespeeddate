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
  @vite(['resources/js/pages/datatables.js'])
@endsection

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            Students
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Overview of all students.
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">Examples</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Students
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
      <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm">
          <thead>
            <tr>
              <th>Image</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
              <th>Teacher</th>
              <th style="width: 15%;">Registered</th>
            </tr>
          </thead>
          <tbody>
            @foreach($students as $student)
              <tr>
                <td style="padding: 3px;" class="fw-semibold d-flex justify-content-center">
                  <img class="" style="width: 60px; height: 60px" src="{{$student->profilePicture}}" alt="">
                </td>
                <td class="fw-semibold">
                  <a href="javascript:void(0)">{{$student->first_name}}</a>
                </td>
                <td class="fw-semibold">
                  <a href="javascript:void(0)">{{$student->last_name}}</a>
                </td>
                <td class="d-none d-sm-table-cell">
                    <span class="text-muted">{{$student->email}}</span>
                </td>
                <td class="d-none d-sm-table-cell">
                    @if(isset($student->sub_user->teacher))
                    <span class="text-muted">{{$student->sub_user->teacher->user->fullname()}}</span>
                    @endif
                </td>
                <td class="text-muted">
                  {{ now() }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- END Page Content -->
@endsection