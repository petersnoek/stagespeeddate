@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Update Company
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
                            Update Company
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    {{-- @if(session('success'))
    {{dd(session('success'))}}
    @endif --}}
    <div class="content">
        <div class="block block-rounded px-5 py-3">
            <div class="block-content block-content-full">
                <div >
                    <form method="POST" action="{{route('Company.save')}}" class="d-flex justify-content-evenly" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="col-sm-8 col-xl-6">
                            <div class="mb-4">
                                <label for="">Name: </label>
                                <input type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("name",$errors)) {{'is-invalid'}} @endif" name="name" placeholder="Company name*"  value="@if(old()){{old('name')}}@else{{$company->name}}@endif" required>
                            
                                @if (count($errors) > 0 && array_key_exists("name",$errors))
                                    @foreach($errors['name'] as $error)
                                        <div class="invalid-feedback">
                                            {{$error}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="">E-mail: </label>
                                <input type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("email",$errors)) {{'is-invalid'}} @endif" name="email" placeholder="Company E-mail"  value="@if(old()){{old('email')}}@else{{$company->email}}@endif">
                            
                                @if (count($errors) > 0 && array_key_exists("email",$errors))
                                    @foreach($errors['email'] as $error)
                                        <div class="invalid-feedback">
                                            {{$error}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="">Bio: </label>
                                <textarea style="max-height: 10rem" maxlength="255" type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("bio",$errors)) {{'is-invalid'}} @endif" name="bio" placeholder="Bio">@if(old()){{old('bio')}}@else{{$company->bio}}@endif</textarea>
                                
                                @if (count($errors) > 0 && array_key_exists("bio",$errors))
                                    @foreach($errors['bio'] as $error)
                                        <div class="invalid-feedback">
                                            {{$error}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="">Description: </label>
                                <textarea style="max-height: 10rem" maxlength="255" type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("description",$errors)) {{'is-invalid'}} @endif" name="description" placeholder="Description">@if(old()){{old('description')}}@else{{$company->description}}@endif</textarea>
                                
                                @if (count($errors) > 0 && array_key_exists("description",$errors))
                                    @foreach($errors['description'] as $error)
                                        <div class="invalid-feedback">
                                            {{$error}}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-8 col-xl-5">
                            <div class="mb-4 ">
                                
                                <div style="overflow-y:hidden; height:11.75rem" class="form-control form-control-alt rounded-0 rounded-top py-3 pb-0">
                                    <div style="overflow:hidden; height:11.75rem;" class="position-relative">
                                        <img id='headerPreview' style="top: 50%; left: 50%; transform: translate(-50%, -50%); min-height: 11.75rem; min-width: 100%" class="w-100 position-absolute" src="{{asset($company->image)}}" alt="kan afbeelding niet inladen.">
                                        {{-- image still stretches a bit cuz I can't not give it a width or height; this is like near impossible --}}
                                    </div>                                
                                </div>
                                <label for="imageInput" class="btn btn-lg btn-alt-primary rounded-0 rounded-bottom py-3 text-muted fw-normal w-100 @if (count($errors) > 0 && array_key_exists("image",$errors)) {{'is-invalid'}} @endif">Image</label>
                                <input id="imageInput" class="visually-hidden" type="file" name="image" onchange="headerPreview.src=window.URL.createObjectURL(this.files[0])" accept="image/png, image/jpg, image/jpeg">
                            </div>
                            @if (count($errors) > 0 && array_key_exists("image",$errors))
                                @foreach($errors['image'] as $error)
                                    <div class="invalid-feedback">
                                        {{$error}}
                                    </div>
                                @endforeach
                            @endif
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-lg btn-alt-primary">
                                    Save changes
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

