@extends('layouts.app')

@section('content')
<div class="container" id="candidate_form">

    <h1 class="text-center h1">| {{ __('Formularz kandydata') }} |</h1>

    <form>
        <div class="accordion mt-5" id="accordionPanelsStayOpenExample">
            {{-- Dane osobowe --}}
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    {{ __('Dane osobowe') }}
                </button>
              </h2>
              <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
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
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                    {{ __('Doświadczenie zawodowe') }}
                </button>
              </h2>
              <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show">

                <div class="accordion-body border" id="1">
                    <div class="row">
                        <div class="mb-3 row">
                            <label for="start_date" class="col-sm-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
                            <div class="col-sm-10">
                              <input type="date" class="form-control" id="start_date" name="start_date[]" value="">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="end_date" class="col-sm-2 col-form-label">{{ __('Data zakończenia') }}</label>
                            <div class="col-sm-10">
                              <div class="input-group mb-3">
                                <div class="input-group">
                                  <input type="date" class="form-control" id="start_date" name="start_date[]" value="">
                                  <div class="input-group-text">
                                    <input class="form-check-input mt-0 me-2" type="checkbox" value="" aria-label="Checkbox for following text input">
                                    {{ __('Trwa nadal') }}
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="company_name" class="col-sm-2 col-form-label">{{ __('Nazwa firmy') }}</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="company_name[]" value="">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="position" class="col-sm-2 col-form-label">{{ __('Stanowisko') }}</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="position[]" value="">
                            </div>
                        </div>

                        <div class="mb-3 row">
                          <label for="position" class="col-sm-2 col-form-label">{{ __('Zakres obowiązków') }}</label>
                          <textarea class="form-control" name="" id="" rows="5"></textarea>
                        </div>
                    </div>
                    <button class="btn btn-primary">{{ __('Dodaj Pozycję') }}</button>
                    <button class="btn btn-primary">{{ __('Usuń Pozycję') }}</button>
                </div>

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
