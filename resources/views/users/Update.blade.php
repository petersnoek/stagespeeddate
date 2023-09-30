@extends('layouts.backend')

@section('content')

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Update je account
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
                            Update Gebruiker
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
                    <form method="POST" action="{{route('users.sendLogin')}}">
                        @csrf
                        <div class="mb-4">
                            <label>Email: </label>
                            <input type="text" class="form-control form-control-lg form-control-alt py-3 @if (count($errors) > 0 && array_key_exists("email",$errors)) {{'is-invalid'}} @endif" name="email" placeholder="address@domein.nl"  value="{{old('email')}}" required>
                        
                            @if (count($errors) > 0 && array_key_exists("email",$errors))
                                @foreach($errors['email'] as $error)
                                    <div class="invalid-feedback">
                                        {{$error}}
                                    </div>
                                @endforeach
                            @endif

                            <label>Account type</label>
                            <select type="text" class="form-select form-control-alt" name="type" required>
                                <option value="">-</option>
                                <option value="company">Bedrijf</option>
                                <option value="teacher">Docent</option>
                            </select>

                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-lg btn-alt-primary">
                                Update account
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

