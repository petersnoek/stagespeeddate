@extends('layouts.backend')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update Company</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('Company.save')}}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Name: </label>
                                <input name="name" type="text" value="{{$company->name}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Bio: </label>
                                <textarea name="bio">{{$company->bio}}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="">Image: </label>
                            </div>
                        </div>
                        <input type="submit" value="Save Changes">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

