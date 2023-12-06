@extends('layouts.app')

@section('content')
<div class="container" id="candidate_form">

    <h1 class="text-center h1">| {{ __('Formularz kandydata') }} |</h1>

    <form method="POST" action="{{route('addEdit')}}">
        @csrf
        <div class="accordion mt-5" id="accordionPanels">
            {{-- Szukam --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#looking_for" aria-expanded="true" aria-controls="looking_for">
                        {{ __('Szukam') }}
                    </button>
                </h2>
                <div id="looking_for" class="accordion-collapse collapse show">
                    <div class="accordion-body">

                        {{-- Docelowe stanowisko --}}
                        <div class="input-group">
                            <label for="position_id" class="col-sm-2 col-form-label">{{ __('Docelowe stanowisko') }}</label>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" @if(!empty($personal_data->position_id)) aria-disabled="true" @endif  id="position_id" name="position_id[]" value="{{ isset($personal_data->position_id) ? $personal_data->position_id : '' }}">
                                        <div class="input-group-text">
                                          <input
                                              class="form-check-input mt-0 me-2"
                                              onclick="onLocationCheckbox()"
                                              type="checkbox"
                                              id="position_checkbox"
                                              @if(!empty($personal_data->position_id)) checked @endif
                                              aria-label="{{ __('Trwa nadal') }}"
                                          >
                                          {{ __('Inne') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Docelowe stanowisko inne --}}
                        <div class="mb-3 row" id="position_name_label">
                            <label for="position_name" class="col-sm-2 col-form-label">{{ __('Podaj stanowisko') }}</label>
                            <div class="col-sm-10">
                                <input type="text" required class="form-control" id="position_name" name="position_name" value="{{ isset($personal_data->position_name) ? $personal_data->position_name : '' }}">
                            </div>
                        </div>

                        {{-- Lokalizacja --}}
                        <div class="mb-3 row">
                            <label for="location" class="col-sm-2 col-form-label">{{ __('Lokalizacja') }}</label>
                            <div class="col-sm-10">
                                <input type="text" required class="form-control" id="location" name="location" value="{{ isset($personal_data->location) ? $personal_data->location : '' }}">
                            </div>
                        </div>

                        {{-- Od kiedy mogę zacząć --}}
                        <div class="mb-3 row">
                            <label for="start_date" class="col-sm-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
                            <div class="col-sm-10">
                              <input type="date" class="form-control" id="exstart_date" name="start_date" value="{{ isset($personal_data->start_date) ? $personal_data->start_date : '' }}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

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
                          <input type="text" required class="form-control" id="firstname" name="firstname" value="{{ $personal_data->firstname }}">
                        </div>
                    </div>

                    {{-- Nazwisko --}}
                    <div class="mb-3 row">
                        <label for="lastname" class="col-sm-2 col-form-label">{{ __('Nazwisko') }}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="lastname" name="lastname" value="{{ $personal_data->lastname }}">
                        </div>
                    </div>

                    {{-- Płeć --}}
                    <div class="mb-3 row">
                        <label for="sex" class="col-sm-2 col-form-label">{{ __('Płeć') }}</label>
                        <div class="col-sm-10">
                        <select class="form-select" name="sex" aria-label="{{ __('Płeć')}}">
                            <option @empty($personal_data->sex) selected @endempty>{{ __('Wybierz') }}</option>
                            <option @if($personal_data->sex == 1) @endif value="1">{{ __('Kobieta') }}</option>
                            <option @if($personal_data->sex == 2) selected @endif value="2">{{ __('Mężczyzna') }}</option>
                        </select>
                        </div>
                    </div>

                    {{-- Adres e-mail --}}
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                        <div class="col-sm-10">
                          <input type="text" readonly class="form-control-plaintext" id="email" name="email" value="{{ $personal_data->email }}">
                        </div>
                    </div>

                    {{-- Numer telefonu --}}
                    <div class="mb-3 row">
                        <label for="phone" class="col-sm-2 col-form-label">{{ __('Numer telefonu') }}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="phone" name="phone" value="{{ $personal_data->phone }}">
                        </div>
                    </div>

                    {{-- Ulica --}}
                    <div class="mb-3 row">
                        <label for="street" class="col-sm-2 col-form-label">{{ __('Ulica') }}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="street" name="street" value="{{ $personal_data->street }}">
                        </div>
                    </div>

                    {{-- Numer domu --}}
                    <div class="mb-3 row">
                        <label for="street_number" class="col-sm-2 col-form-label">{{ __('Numer domu') }}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="street_number" name="street_number" value="{{ $personal_data->street_number }}">
                        </div>
                    </div>

                    {{-- Numer lokalu --}}
                    <div class="mb-3 row">
                        <label for="flat_number" class="col-sm-2 col-form-label">{{ __('Numer lokalu') }}</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="flat_number" name="flat_number" value="{{ $personal_data->flat_number }}">
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
                <div class="accordion-body">
                    <input id="expirience_last" value="{{ $work_expirience['count'] }}" type="hidden" >

                    {!! $work_expirience['result'] !!}
                </div>
              </div>
            </div>

            {{-- Wykształcenie --}}
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#education" aria-expanded="true" aria-controls="education">
                    {{ __('Wykształcenie') }}
                </button>
              </h2>
              <div id="education" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    <input id="education_last" value="{{ $education['count'] }}" type="hidden" >

                    {!! $education['result'] !!}
                </div>
            </div>

            {{-- Umiejętności --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#skills" aria-expanded="true" aria-controls="skills">
                        {{ __('Umiejętności') }}
                    </button>
                </h2>
                <div id="skills" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <input id="skills_last" value={{ $skills['count'] }} type="hidden" >

                        {!! $skills['result'] !!}
                    </div>
                </div>
            </div>

            {{-- Zainteresowania --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#interests" aria-expanded="true" aria-controls="interests">
                        {{ __('Zainteresowania') }}
                    </button>
                </h2>
                <div id="interests" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <input id="interests_last" value={{ $interests['count'] }} type="hidden" >

                        {!! $interests['result'] !!}
                    </div>
                </div>
            </div>

            <button type="submit" name="save" value="1" class="btn btn-primary addButton">{{ __('Zapisz') }}</button>
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
                <input type="hidden" name="exp_id[]">
                <input type="hidden" id="exp_in_progress_${index}" name="exp_in_progress[]" value="">

                <div class="row">
                    <div class="mb-3 row">
                        <label for="exp_start_date_${index}" class="col-sm-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
                        <div class="col-sm-10">
                        <input type="date" class="form-control" id="exp_start_date_${index}" name="exp_start_date[]" value="">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="exp_end_date_${index}" class="col-sm-2 col-form-label">{{ __('Data zakończenia') }}</label>
                        <div class="col-sm-10">
                        <div class="input-group mb-3">
                            <div class="input-group">
                            <input type="date" class="form-control" id="exp_end_date_${index}" name="exp_end_date[]" value="">
                            <div class="input-group-text">
                                <input
                                    class="form-check-input mt-0 me-2"
                                    onclick="expChecked('exp', ${index})"
                                    type="checkbox"
                                    name="exp_in_progress[]"
                                    aria-label="{{ __('Trwa nadal') }}"
                                >
                                {{ __('Trwa nadal') }}
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="exp_company_name_${index}" class="col-sm-2 col-form-label">{{ __('Nazwa firmy') }}</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="exp_company_name_${index}" name="exp_company_name[]" value="">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="exp_position_${index}" class="col-sm-2 col-form-label">{{ __('Stanowisko') }}</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="exp_position_${index}" name="exp_position[]" value="">
                        </div>
                    </div>

                    <div class="mb-3 row">
                    <label for="exp_responsibilities_${index}" class="col-sm-2 col-form-label">{{ __('Zakres obowiązków') }}</label>
                    <textarea class="form-control" name="exp_responsibilities[]" id="exp_responsibilities_${index}" rows="5"></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-primary addButton" onclick="addNewPosition()">{{ __('Dodaj Pozycję') }}</button>
                <button type="button" class="btn btn-primary delButton" onclick="removePosition(${index})">{{ __('Usuń Pozycję') }}</button>

            </div>`);
    }

    function addNewEdu() {
        const educations = $('#education');

        const last = $('#education_last').val();
        $('#education_last').val(+last + 1);
        const index = $('#education_last').val()

        // Dodać zabezpieczenie max 5

        educations.append(`
            <div class="accordion-body border" index="${index}">
                <input type="hidden" name="edu_id[]" value="" >
                <input type="hidden" id="edu_in_progress_${index}" name="edu_in_progress[]" value="">

                <div class="row">
                    <div class="mb-3 row">
                        <label for="edu_start_date_${index}" class="col-sm-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
                        <div class="col-sm-10">
                        <input type="date" class="form-control" id="edu_start_date_${index}" name="edu_start_date[]" value="">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="end_date_${index}" class="col-sm-2 col-form-label">{{ __('Data zakończenia') }}</label>
                        <div class="col-sm-10">
                        <div class="input-group mb-3">
                            <div class="input-group">
                            <input type="date" class="form-control" id="edu_end_date_${index}" name="edu_end_date[]" value="">
                            <div class="input-group-text">
                                <input
                                    class="form-check-input mt-0 me-2"
                                    onclick="onCheckBoxChange( 'edu' , ${index})"
                                    type="checkbox"
                                    id="edu_checkbox_${index}"
                                    aria-label="{{ __('Trwa nadal') }}"
                                >
                                {{ __('Trwa nadal') }}
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="edu_education_name_${index}" class="col-sm-2 col-form-label">{{ __('Nazwa uczelni') }}</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="edu_education_name_${index}" name="edu_education_name_[]" value="">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="edu_education_name_${index}" class="col-sm-2 col-form-label">{{ __('Kierunek') }}</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="edu_education_name_${index}" name="edu_education_name_[]" value="">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="edu_title_${index}" class="col-sm-2 col-form-label">{{ __('Tytuł') }}</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="edu_title_${index}" name="edu_title[]" value="">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary addButton" onclick="addNewEdu()">{{ __('Dodaj Pozycję') }}</button>
                <button type="button" class="btn btn-primary delButton" onclick="removePosition(${index})">{{ __('Usuń Pozycję') }}</button>

            </div>`);

    }

    function addNewSkill() {
        const skills = $('#skills');

        const last = $('#skills_last').val();
        $('#skills_last').val(+last + 1);
        const index = $('#skills_last').val();

        // @TODO Dodać zabezpiecznie max 10

        skills.append(`
            <div class="accordion-body border" index="${index}">
                <input type="hidden" name="skill_id[]" value="" >

                <div class="row">
                    <div class="mb-3 row">
                        <label for="skill_name_${index}" class="col-sm-2 col-form-label">{{ __('Nazwa umiejętności') }}</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="skill_name_${index}" name="skill_name[]" value="">
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary addButton" onclick="addNewSkill()">{{ __('Dodaj Pozycję') }}</button>
                <button type="button" class="btn btn-primary delButton" onclick="removePosition(${index})">{{ __('Usuń Pozycję') }}</button>
            </div>
        `);
    }

    function addNewInt() {
        const interests = $('#interests');

        const last = $('#interests_last').val();
        $('#interests_last').val(+last + 1);
        const index = $('#interests_last').val();

        // @TODO Dodać zabezpieczenie max 10

        interests.append(`
            <div class="accordion-body border" index="${index}">
                <input type="hidden" name="int_id[]" value="" >

                <div class="row">
                    <div class="mb-3 row">
                        <label for="int_name_${index}" class="col-sm-2 col-form-label">{{ __('Nazwa zainteresowania') }}</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="int_name_${index}" name="int_name[]" value="">
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary addButton" onclick="addNewInt()">{{ __('Dodaj Pozycję') }}</button>
                <button type="button" class="btn btn-primary delButton" onclick="removePosition(${index})">{{ __('Usuń Pozycję') }}</button>
            </div>`
        );
    }

    function removePosition(index) {
        $(`.accordion-body[index="${index}"]`).remove();
    }

    function onCheckBoxChange(prefix, index) {
        const target = $('#' + prefix + '_in_progress_' + index);
        const checked = $('#' + prefix + '_checkbox_' + index).prop('checked');

        if(checked) {
            $('#' + prefix + '_end_date_' + index).attr('aria-disabled', true);
            $('#' + prefix + '_end_date_' + index).val('');
        } else {
            $('#' + prefix + '_end_date_' + index).attr("aria-disabled", false);
        }

        target.val(checked ? 1 : 0);
    }

    function onLocationCheckbox() {
        const target = $('#position');
        const checked = $('#position_checkbox').prop('checked');

        // if(checked) {

        // } else {

        // }

        // tar
    }
</script>
@endsection
