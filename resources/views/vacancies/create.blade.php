@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <style>
        small {
            position: absolute;
            color: whitesmoke;
            background: #1F2937;
            padding: 4px;
            margin: 4px;
            border-radius: 5px;
            display: none;
        }

        label:hover small{
            display: initial;
        }
    </style>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Create Vacancy
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">

                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Create Vacancy
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content">
        <div class="block block-rounded px-5 py-3">
            <div class="block-content block-content-full">
                <div >
                    @include('layouts.partials.messages')
                    <form method="POST" action="{{route('vacancy.store')}}" class="d-flex justify-content-evenly" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="col-sm-8 col-xl-6">
                            <div class="mb-4">
                                <label for="">Name: </label>
                                <input type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("name",$errors)) {{'is-invalid'}} @endif" name="name" placeholder="Vacancy name*" required>
                            
                                @if (count($errors) > 0 && array_key_exists("name",$errors))
                                    @foreach($errors['name'] as $error)
                                        <div class="invalid-feedback">
                                            {{$error}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="">Bio: 
                                    <i class="fa-circle-info fa-sharp fa-solid"></i>
                                    <br>
                                    <small>Tell us about your vacancy in a short description.</small>
                                </label>
                                <textarea style="max-height: 10rem" maxlength="255" type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("bio",$errors)) {{'is-invalid'}} @endif" name="bio" placeholder="Bio"></textarea>
                                @if (count($errors) > 0 && array_key_exists("bio",$errors))
                                    @foreach($errors['bio'] as $error)
                                        <div class="invalid-feedback">
                                            {{$error}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="">Description: 
                                    <i class="fa-circle-info fa-sharp fa-solid"></i>
                                    <br>
                                    <small style="">Here you write all the information and details of your vacancy.</small>
                                </label>
                                <textarea style="max-height: 10rem" maxlength="255" type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("description",$errors)) {{'is-invalid'}} @endif" name="description" placeholder="Description"></textarea>
                                @if (count($errors) > 0 && array_key_exists("description",$errors))
                                    @foreach($errors['description'] as $error)
                                        <div class="invalid-feedback">
                                            {{$error}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div>
                                <button type="submit" class="btn btn-lg btn-alt-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    </div>
    <!-- END Page Content -->
@endsection

