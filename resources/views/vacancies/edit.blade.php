@extends('layouts.backend') 

@section('content')

    <h1 style="padding-left: 20px; padding-top: 20px;">Edit Vacancy</h1>

    <div class="container">
        <div class="block block-rounded px-5 py-3">
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

                <div class="mb-4">
                    <label for="">Bio:
                        <i class="fas fa-info-circle"></i>   
                        <br>
                        <small>Een korte beschrijving van de vacature</small>
                    </label>
                    <textarea rows=4 class="form-control" id="bio" name="bio">{{ $vacancy->bio }}</textarea>
                    <p>Characters used: <span id="charUsed">{{ strlen($vacancy->bio) }}</span>/255</p>
                </div>

                <div class="mb-4">
                    <label for="bio">Beschrijving:
                        <i class="fa-circle-info fa-sharp fa-solid"></i>
                        <br>
                        <small>een uitgebreide beschrijving van de vacatuur</small>
                    </label>
                    <textarea rows=4 class="form-control" id="description" name="description">{{ $vacancy->description }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
            </div>
    </div>

    <script>
        const bioTextarea = document.getElementById('bio');
        const charUsedSpan = document.getElementById('charUsed');

        bioTextarea.addEventListener('input', function () {
            const currentLength = bioTextarea.value.length;
            charUsedSpan.textContent = currentLength;
        });
    </script>


@endsection
