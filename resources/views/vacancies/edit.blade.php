@extends('layouts.backend')

@section('content')


    <div class="container">
        <h1>Edit Vacancy</h1>
        <form action="{{ route('vacancy.update', ['company_id' => $vacancy->company_id, 'vacancy_id' => $vacancy->id]) }}" method="POST">
            @csrf
            @method('POST') 

            <div class="mb-3">
                <label for="name" class="form-label">Vacatuur naam</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $vacancy->name }}">
            </div>

            <div class="mb-3">
                <label for="niveau" class="form-label">Niveau</label>
                <select class="form-select" id="niveau" name="niveau">
                    <option value="3" {{ $vacancy->niveau == '3' ? 'selected' : '' }}>3</option>
                    <option value="4" {{ $vacancy->niveau == '4' ? 'selected' : '' }}>4</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
