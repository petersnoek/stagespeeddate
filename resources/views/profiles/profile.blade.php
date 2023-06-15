
<!-- nav bar linked -->
@extends('layouts.backend')

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

<!-- cleans up the cv parameter to make it more user friendly, it has some protection build in when saving to prefent repeates and this cleans that off. -->
@php
  if(Auth::user()->role == 'student')
  {
    $value = Auth::user()->student->CV;
    if($value != ""){
      $cv = explode('/', $value)[1] ?? null;
      $cv = explode(',', $cv)[1] ?? null;
    }
    else{
      $cv = "there is nothing here";
    }
  }
@endphp

@section('content')
<!-- header -->
<div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            Profile
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Welcome to your profile {{Auth::user()->first_name}}, here you can see your credentials and change them if needed.
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{route('home')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{route('profile')}}">Profile</a>
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
        @include('layouts.partials.messages')
            <div class="d-flex justify-content-evenly">
                <div class="col-sm-8 col-xl-6">
                    <div class="mb-4">
                        <label for="">First Name: </label>
                        <p type="text" class="form-control form-control-lg form-control-alt py-3"> {{Auth::user()->first_name}} </p>
                    </div>

                    <div class="mb-4">
                        <label for="">Last Name: </label>
                        <p type="text" class="form-control form-control-lg form-control-alt py-3"> {{Auth::user()->last_name}} </p>
                    </div>

                    <div class="mb-4">
                        <label for="">E-mail: </label>
                        <p type="text" class="form-control form-control-lg form-control-alt py-3"> {{ Auth::user()->email }} </p>
                    </div>
                    @if( Auth::user()->role == 'student' )
                    <div class="mb-4">
                        <label for="">CV: </label>
                        @if($cv == 'there is nothing here')
                          <p type="text" class="form-control form-control-lg form-control-alt py-3"> {{ $cv }} </p>
                        @endif
                        @if($cv != 'there is nothing here')
                          <a type="text" class="form-control form-control-lg form-control-alt py-3" href="{{ route('profile.downloadCv') }}"> {{ $cv }} </a>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="col-sm-8 col-xl-5">
                    <div class="mb-4 d-flex justify-content-center"> <!-- to change the postion of the picture frame, change the translate in the first div below this line, first % is horizontal movement, second % is vertical movement -->
                        <div style="overflow-y:hidden; height:18rem; width: 18rem;" class="form-control form-control-alt rounded-0 rounded-top py-3 pb-0">
                            <div style="overflow:hidden; height:16rem;" class="position-relative">
                                <img id='headerPreview' style="top: 50%; left: 50%; transform: translate(-50%, -50%); min-height: 11.75rem; min-width: 100%" class="w-100 position-absolute" src="{{ asset(Auth::user()->profilePicture) }}" alt="kan afbeelding niet inladen.">
                                {{-- image still stretches a bit cuz I can't not give it a width or height; this is like near impossible --}}
                            </div>                                
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <form action="{{ route('profile.updateCredentialsForm') }}">
                            <button type="submit" class="btn btn-lg btn-alt-primary" style="margin-right: 2.5px">
                                update credentials
                            </button>
                        </form>
                        <form action="{{ route('profile.updatePasswordForm') }}">
                            <button type="submit" class="btn btn-lg btn-alt-primary" style="margin-left: 2.5px">
                                update password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Dynamic Table with Export Buttons -->
</div>
<!-- END Page Content -->
@endsection