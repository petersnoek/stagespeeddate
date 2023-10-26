@extends('layouts.backend')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Aanmelden voor {{$vacancy->name}}
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
                            Vacatures
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{$vacancy->name}}
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Aanmelden
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content px-8">
        <div class="block block-rounded px-5 py-3">
            <div class="block-content block-content-full">
                <div>
                @include('layouts.partials.messages')
                    <form method="POST" action="{{route('application.send', ['vacancy_id' => $vacancy->id, 'company_id' => $vacancy->company->id])}}" class="d-flex justify-content-evenly" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <h3>Motivatie</h3>
                            <p>Schrijf hier in het kort over jezelf en waarom jij je graag zou willen aanmelden bij dit bedrijf. De onderstaande gegevens worden doorgestuurd naar het bedrijf.</p>
                            <ul>
                                <li>Voor- en achternaam</li>
                                <li>E-mail</li>
                                <li>CV</li>
                            </ul>
                            <label >Motivatie Brief:</label>
                                <div>
                                    <input id="motiInput" style="opacity: 0;" class="position-absolute" type="file" name="motivation" onchange="motiLabel.innerHTML=this.files[0]['name']" accept="application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
                                    <label for="motiInput" style="float:left;" class="btn btn-lg btn-alt-primary text-muted py-3 @if (count($errors) > 0 && array_key_exists("motivation",$errors)) {{'is-invalid btn-alt-danger'}} @endif" required>Kies een bestand</label>
                                    <label id="motiLabel" style="max-width:70%; margin-left: 10px;" class="text-truncate py-3">Geen bestand gekozen</label>
                                    @if (count($errors) > 0 && array_key_exists("motivation",$errors))
                                        @foreach($errors['motivation'] as $error)
                                            <div class="invalid-feedback">
                                                {{$error}}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>                                                                                                 
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
                            <br>
                            <input type="submit" class="btn btn-lg btn-alt-primary" value="verzend">
                        </div>
                    </form> 
                <div >

                </div>
            </div>
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    </div>
    <!-- END Page Content -->
@endsection