@extends('layouts.app')

@section('content')
<div class="container" id="candidate_form">

    <h1 class="text-center h1">| {{ __('Formularz kandydata') }} |</h1>

    <form>
        <div class="accordion mt-5" id="accordionPanels">
            {{-- Dane osobowe --}}
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#personal_data" aria-expanded="true" aria-controls="personal_data">
                    {{ __('Dane osobowe') }}
                </button>
              </h2>
              <div id="personal_data" class="accordion-collapse collapse show">
                <div class="accordion-body">

                    {{-- Imię --}}
                    <div class="mb-3 row">
                        <label for="firstname" class="col-sm-2 col-form-label">{{ __('Imię') }}</label>
                        <div class="col-sm-10">
                          <input type="text" required class="form-control" id="firstname">
                        </div>
                    </div>

                    {{-- Nazwisko --}}
                    <div class="mb-3 row">
                        <label for="firstname" class="col-sm-2 col-form-label">{{ __('Nazwisko') }}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="firstname">
                        </div>
                    </div>

                    {{-- Płeć --}}
                    <div class="mb-3 row">
                        <label for="sex" class="col-sm-2 col-form-label">{{ __('Płeć') }}</label>
                        <div class="col-sm-10">
                        <select class="form-select" aria-label="Default select example">
                            <option selected>{{ __('Wybierz') }}</option>
                            <option value="0">{{ __('Kobieta') }}</option>
                            <option value="1">{{ __('Mężczyzna') }}</option>
                        </select>
                        </div>
                    </div>

                    {{-- Adres e-mail --}}
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                        <div class="col-sm-10">
                          <input type="text" readonly class="form-control-plaintext" id="email" value="{{ Auth()->user()->email }}">
                        </div>
                    </div>

                    {{-- Numer telefonu --}}
                    <div class="mb-3 row">
                        <label for="phone" class="col-sm-2 col-form-label">{{ __('Numer telefonu') }}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="phone" value="">
                        </div>
                    </div>

                    {{-- Ulica --}}
                    <div class="mb-3 row">
                        <label for="street" class="col-sm-2 col-form-label">{{ __('Ulica') }}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="street" value="">
                        </div>
                    </div>

                    {{-- Numer domu --}}
                    <div class="mb-3 row">
                        <label for="street_number" class="col-sm-2 col-form-label">{{ __('Numer domu') }}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="street_number" value="">
                        </div>
                    </div>

                    {{-- Numer lokalu --}}
                    <div class="mb-3 row">
                        <label for="flat_number" class="col-sm-2 col-form-label">{{ __('Numer lokalu') }}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="flat_number" value="">
                        </div>
                    </div>

                    {{-- Zdjęcie --}}

                </div>
              </div>
            </div>

            {{-- Doświadczenie zawodowe --}}
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#work-expirience" aria-expanded="true" aria-controls="work-expirience">
                    {{ __('Doświadczenie zawodowe') }}
                </button>
              </h2>
              <div id="work-expirience" class="accordion-collapse collapse show">
                <input id="expirience_last" value="{{ $count }}" type="hidden" >

                {!! $work_expirience !!}

              </div>
            </div>

            {{-- Wykształcenie --}}
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                    {{ __('Wykształcenie') }}
                </button>
              </h2>
              <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show">
                <div class="accordion-body">

              </div>
            </div>

            {{-- Zainteresowania --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseFour">
                        {{ __('Zainteresowania') }}
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show">
                    <div class="accordion-body">

                    </div>
                </div>
            </div>
    </form>
</div>
@endsection


@section('script')
<script>
    function addNewPosition() {
        const workExpirience = $('#work-expirience');

        const last = $('#expirience_last').val();
        $('#expirience_last').val(+last + 1);
        const index = $('#expirience_last').val();

        // Dodać zabezpieczenie max 5

        workExpirience.append(`
            <div class="accordion-body border" index="${index}">
                <div class="row">
                    <div class="mb-3 row">
                        <label for="start_date_${index}" class="col-sm-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
                        <div class="col-sm-10">
                        <input type="date" class="form-control" id="start_date_${index}" name="start_date[]" value="">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="end_date_${index}" class="col-sm-2 col-form-label">{{ __('Data zakończenia') }}</label>
                        <div class="col-sm-10">
                        <div class="input-group mb-3">
                            <div class="input-group">
                            <input type="date" class="form-control" id="end_date_${index}" name="end_date[]" value="">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0 me-2" type="checkbox" value="" aria-label="{{ __('Trwa nadal') }}">
                                {{ __('Trwa nadal') }}
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="company_name_${index}" class="col-sm-2 col-form-label">{{ __('Nazwa firmy') }}</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="company_name_${index}" name="company_name[]" value="">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="position_${index}" class="col-sm-2 col-form-label">{{ __('Stanowisko') }}</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="position_${index}" name="position[]" value="">
                        </div>
                    </div>

                    <div class="mb-3 row">
                    <label for="responsibilities_${index}" class="col-sm-2 col-form-label">{{ __('Zakres obowiązków') }}</label>
                    <textarea class="form-control" name="responsibilities[]" id="responsibilities_${index}" rows="5"></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-primary addButton" onclick="addNewPosition()">{{ __('Dodaj Pozycję') }}</button>
                <button type="button" class="btn btn-primary delButton" onclick="removePosition(${index})">{{ __('Usuń Pozycję') }}</button>

            </div>`);

    }

    function removePosition(index) {
        $(`.accordion-body[index="${index}"]`).remove();
    }
</script>
@endsection
