@extends('layouts.backend')

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
                        <a style="width: fit-content; height: fit-content;" class="form-control form-control-lg form-control-alt" href="{{route('company.update')}}""><i class="fa fa-pen"></i></a>
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
            <div class=" block-content-full">
                <div class="col-sm-8 col-xl-11">
                    <h5 style="margin: 0px; " class="p-1">Over ons bedrijf</h5>
                    <div class="p-2">{{$company->description}}</div>
                </div>
            </div>
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    </div>
    <!-- END Page Content -->
@endsection

