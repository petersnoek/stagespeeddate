
<!-- nav bar linked -->
@extends('layouts.backend')


@section('content')

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

<!-- header -->
<div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            Update your credentials
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Here you can change your credentials by updating the information in the fields, click on update when you are done.
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="/">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a class="link-fx" href="/profiles/profile">Profile</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
<!-- end of header -->

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded px-5 py-3">
        <div class="block-content block-content-full">
            <div>
                @include('layouts.partials.messages')
                <form method="POST" action="{{route('Students.update')}}" class="d-flex justify-content-evenly" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="col-sm-8 col-xl-6">
                        <div class="mb-4">
                            <label for="">First Name: </label>
                            <input type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("name",$errors)) {{'is-invalid'}} @endif" name="name" placeholder="{{Auth::user()->first_name}} name*"  value="@if(old()){{old('first_name')}}@else{{ Auth::user()->first_name }}@endif" required>
                        
                            @if (count($errors) > 0 && array_key_exists("name",$errors))
                                @foreach($errors['first_name'] as $error)
                                    <div class="invalid-feedback">
                                        {{$error}}
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="">Last Name: </label>
                            <input type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("name",$errors)) {{'is-invalid'}} @endif" name="name" placeholder="{{Auth::user()->last_name}} name*"  value="@if(old()){{old('first_name')}}@else{{ Auth::user()->last_name }}@endif" required>
                        
                            @if (count($errors) > 0 && array_key_exists("name",$errors))
                                @foreach($errors['last_name'] as $error)
                                    <div class="invalid-feedback">
                                        {{$error}}
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="">E-mail: </label>
                            <input type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("email",$errors)) {{'is-invalid'}} @endif" name="email" placeholder="{{ Auth::user()->email }}"  value="@if(old()){{old('email')}}@else{{ Auth::user()->email }}@endif">
                        
                            @if (count($errors) > 0 && array_key_exists("email",$errors))
                                @foreach($errors['email'] as $error)
                                    <div class="invalid-feedback">
                                        {{$error}}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-8 col-xl-5">
                    <div class="mb-4"> <!-- to change the postion of the picture frame, change the translate in the first div below this line, first % is horizontal movement, second % is vertical movement -->
                        <div style="overflow-y:hidden; transform: translate(40%,0%); height:18rem; width: 18rem;" class="form-control form-control-alt rounded-0 rounded-top py-3 pb-0">
                                <div style="overflow:hidden; height:16rem;" class="position-relative">
                                    <img id='headerPreview' style="top: 50%; left: 50%; transform: translate(-50%, -50%); min-height: 11.75rem; min-width: 100%" class="w-100 position-absolute" src="{{ asset(Auth::user()->profilePicture) }}" alt="kan afbeelding niet inladen.">
                                    {{-- image still stretches a bit cuz I can't not give it a width or height; this is like near impossible --}}
                                </div>                                
                            </div>
                            <label for="profilePictureInput" style="transform: translate(40%,0%); width:18rem;" class="btn btn-lg btn-alt-primary rounded-0 rounded-bottom py-3 text-muted fw-normal @if (count($errors) > 0 && array_key_exists("profilePicture",$errors)) {{'is-invalid'}} @endif">upload a profile picture</label>
                            <input id="profilePictureInput" class="visually-hidden" type="file" name="profilePicture" onchange="headerPreview.src=window.URL.createObjectURL(this.files[0])" accept="profilePicture/png, profilePicture/jpg, profilePicture/jpeg">
                        </div>
                        @if (count($errors) > 0 && array_key_exists("profilePicture",$errors))
                            @foreach($errors['profilePicture'] as $error)
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