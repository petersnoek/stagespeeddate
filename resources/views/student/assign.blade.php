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
            Studenten Toewijzen
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Een overzicht van alle niet-toegewezen studenten.
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              <a class="link-fx" href="{{ route('student.index') }}">Studenten</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Toewijzen
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
        @include('layouts.partials.messages')
        @if (count($errors) > 0)
          <div class="alert alert-danger">
            <button class="alert-danger" style="float:right; border:none; box-shadow:none; height:24px;" onclick="this.parentElement.remove();"><i class="fa fa-x fa-sm"></i></button>
              <ul style="list-style-type:none" class="m-0 p-0">
                @foreach ($errors as $msg)
                <li>
                  <i class="fa fa-x"></i>
                  {{ $msg[0] }}
                </li>
                @endforeach
              </ul>
          </div>
        @endif
        <form method="POST" action="{{route('student.claim')}}">
          @csrf
          <button class="btn btn-lg btn-alt-primary mb-4" type="submit">Geselecteerde studenten toeweizen</button>
          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
          <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm">
            <thead>
              <tr>
                <th class="sorting_asc_disabled sorting_desc_disabled"></th>
                <th class="sorting_asc_disabled sorting_desc_disabled">Foto</th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
              </tr>
            </thead>
            <tbody>
              @foreach($students as $student)
                <tr>
                  <td>
                    <input type="checkbox" name="student[{{Hashids::encode($student->id)}}]">
                  </td>
                  <td style="padding: 3px;" class="fw-semibold d-flex justify-content-center">
                    <img style="width: 60px; height: 60px" src="{{asset($student->user->profilePicture)}}" alt="profile picture">
                  </td>
                  <td class="fw-semibold">
                    <a href="javascript:void(0)">{{$student->user->first_name}}</a>
                  </td>
                  <td class="fw-semibold">
                    <a href="javascript:void(0)">{{$student->user->last_name}}</a>
                  </td>
                  <td class="d-none d-sm-table-cell">
                    <span class="text-muted">{{$student->user->email}}</span>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
  <!-- END Page Content -->
@endsection