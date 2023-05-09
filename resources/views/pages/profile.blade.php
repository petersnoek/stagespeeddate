
<!-- nav bar linked -->
@extends('layouts.backend')


@section('content')
<!-- header -->
<div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-2">
            Dashboard
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Welcome {{Auth::user()->first_name}}, welcome to your profile.
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">App</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              profile
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
<!-- end of header -->

<!-- Page Content -->
<div class="content">
    <div class="card-body">
        <form method="POST" action="{{ route('Students.update') }}">
            @csrf
            {{method_field('PUT')}}
            <div class="row mb-3">
                <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                <div class="col-md-6">
                    <input id="first_name" type="text" placeholder="{{Auth::user()->first_name}}" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $Student->first_name }}"  autocomplete="first_name" autofocus>

                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                <div class="col-md-6">
                    <input id="last_name" type="text" placeholder="{{Auth::user()->last_name}}" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $Student->last_name }}" autocomplete="last_name" autofocus>

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" placeholder="{{Auth::user()->email}}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $Student->email }}" autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('new Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ $Student->password }}" autocomplete="new-password">
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('update') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection