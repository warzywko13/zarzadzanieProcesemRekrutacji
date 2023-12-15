@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{route('addEditPosition')}}">
        @csrf

        <h1 class="text-center h1">| {{ isset($position->id) ? __('Formularz edycji pozycji') : __('Formularz dodawania pozycji') }} |</h1>

        <div class="accordion mt-5" id="accordionPanels">
            {{-- Szukam --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fw-bold" type="button" aria-expanded="true" aria-controls="position_for">
                        {{ isset($position->id) ? __('Edytuj pozycję') : __('Dodaj pozycję') }}
                    </button>
                </h2>
                <div id="position_for" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <input type="hidden" name="id" id="id" value="{{ isset($position->id) ? $position->id : '' }}">

                        <div class="mb-3 row mt-3">
                            <label for="name" class="col-sm-2 col-form-label">{{ __('Nazwa Stanowiska') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" value="{{ isset($position->name) ? $position->name : '' }}">
                                @isset($error['image'])
                                    <p class="text-danger fw-bold">
                                        {{ $error['image'] }}!
                                    </p>
                                @endisset
                            </div>
                        </div>

                        <div class="container btn-lg">
                            <button type="submit" name="save" value="1" class="d-block mx-auto btn btn-primary addButton my-2 px-5 py-2">{{ isset($position->id) ? __('Edytuj') : __('Dodaj') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
