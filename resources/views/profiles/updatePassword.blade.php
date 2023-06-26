
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
            Wijzig je Wachtwoord
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Hier kan je je wachtwoord wijzigen.
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{route('home')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a class="link-fx" href="{{route('profile')}}">Profiel</a>
            </li>
            <li class="breadcrumb-item">
              Wachtwoord Wijzigen
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
                <form method="POST" action="{{route('profile.updatePassword')}}" class="d-flex justify-content-evenly" enctype="multipart/form-data">
                @csrf
                <div class="col-sm-8 col-xl-6">
                    <div class="mb-4">
                        <label for="">Nieuw Wachtwoord: </label>
                        <input type="password" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("password",$errors)) {{'is-invalid'}} @endif" name="password" placeholder="new password" confirmed autocomplete="new-password" required>
                    </div>

                    <div class="mb-4">
                        <label for="">Bevestig Wachtwoord: </label>
                        <input type="password" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("password",$errors)) {{'is-invalid'}} @endif" name="password_confirmation" placeholder="confirm password" autocomplete="new-password" required>
                        
                        @if (count($errors) > 0 && array_key_exists("password",$errors))
                            @foreach($errors['password'] as $error)
                                <div class="invalid-feedback">
                                    {{$error}}
                                </div>
                            @endforeach
                        @endif
                    </div>
                
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-lg btn-alt-primary">
                            Wijzig Wachtwoord
                        </button>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Dynamic Table with Export Buttons -->
</div>
@endsection