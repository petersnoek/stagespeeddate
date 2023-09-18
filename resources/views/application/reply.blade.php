@extends('layouts.backend')

@section('content')

    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Aanmelding Beantwoorden
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        aanmelding van {{$application->student->user->fullname()}} voor {{$application->vacancy->name}}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{$application->vacancy->company->name}}
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="{{route('company.application.index' , ['company_id' => Hashids::encode(Auth::user()->company->id)])}}">Aanmeldingen</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="{{route('application.show' , ['application_id' => Hashids::encode($application->id) ,'company_id' => Hashids::encode(Auth::user()->company->id)])}}">{{Hashids::encode($application->id)}}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Beantwoorden
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content px-9">
        <div class="block block-rounded px-5 py-3">
            @include('layouts.partials.messages')
            <form method="POST" action="{{route('application.reply.send', ['company_id' => Hashids::encode($application->vacancy->company->id), 'application_id' => Hashids::encode($application->id)])}}" enctype="multipart/form-data">
                <div class="block-content block-content-full">
                    <div>
                        @csrf
                        <div>
                            <div class="btn btn-alt-success">
                                <input id="CheckAccept" type="checkbox" name="accept" onchange="CheckDecline.checked=false">
                                <label for="CheckAccept">Accepteren</label>
                            </div>
                            <div class="btn btn-alt-danger">
                                <input id="CheckDecline" type="checkbox" name="decline" onchange="CheckAccept.checked=false">
                                <label for="CheckDecline">Afweizen</label>
                            </div>
                        </div>
                        <br>
                        <label for="">Jouw bericht:</label>
                        <br>
                        <textarea spellcheck='true' class='form-control form-control-lg form-control-alt @if (count($errors) > 0 && array_key_exists("comment",$errors)) {{'is-invalid'}} @endif' required type="text" name="comment"></textarea>
                        @if (count($errors) > 0 && array_key_exists("comment",$errors))
                            @foreach($errors['comment'] as $error)
                                <div class="invalid-feedback">
                                    {{$error}}
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="d-flex justify-content-end">
                            <input type="hidden" name="application" value="{{Hashids::encode($application->id)}}">
                            <button type="submit" class="btn btn-lg btn-alt-primary mx-3">Beantwoorden</button> 
                            <a class="btn btn-lg btn-alt-primary" href="{{route('application.show' , ['application_id' => Hashids::encode($application->id) ,'company_id' => Hashids::encode(Auth::user()->company->id)])}}">Annuleren</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    </div>
    <!-- END Page Content -->
@endsection

