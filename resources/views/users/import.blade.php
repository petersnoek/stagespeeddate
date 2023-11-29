@extends('layouts.backend')

@section('content')

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Voeg nieuwe gebruikers toe
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">

                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('users.index') }}">Gebruikers</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Importeer gebruikers
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
            <div class="block-content block-content-full d-flex justify-content-center">
                <div class="col-sm-9 col-xl-7">
                    <form method="POST" enctype="multipart/form-data" action="{{route('users.bulkImport')}}">
                        @csrf

                        <div class="mb-4">
                            <label>import users</label>
                            <label for="file">selecteer het bestand wat je wil importeren</label>
                            <input type="file" name="file" id="file">
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-primary">
                                <i class="fa fa-upload"></i> upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    </div>
    <!-- END Page Content -->
@endsection

