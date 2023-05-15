
<!-- nav bar linked -->
@extends('layouts.backend')


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
              <a class="link-fx" href="javascript:void(0)">App</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Profile
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
<!-- end of header -->

<!-- Page Content -->
<div class="content">
    @include('layouts.partials.messages')
    <div class="card-body">
        <div class="row mb-3">
            <label for="first_name" class="col-md-1 col-form-label text-md-end">{{ __('First Name') }}</label>
            
            <div class="col-md-4 col-form-label">
                <a>{{Auth::user()->first_name}}</a>
            </div>
        </div>

        <div class="row mb-3">
            <label for="last_name" class="col-md-1 col-form-label text-md-end">{{ __('Last Name') }}</label>

            <div class="col-md-4 col-form-label">
                <a>{{Auth::user()->last_name}}</a>
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-md-1 col-form-label text-md-end">{{ __('Email Address') }}</label>

            <div class="col-md-4 col-form-label">
                <a>{{Auth::user()->email}}</a>
            </div>
        </div>
        
        <div class="row mb-0">
            <div class="col-md-2">
                <form action="{{ route('Students.updateCredentails') }}">
                    <button class="btn btn-primary">
                        {{ __('update credentials') }}
                    </button>
                </form>
            </div>
        </div>
        <br>
        <div class="row mb-0">
            <div class="col-md-2" >
                <form action="{{ route('Students.updatePassword') }}">
                    <button class="btn btn-primary">
                        {{ __('update password') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection