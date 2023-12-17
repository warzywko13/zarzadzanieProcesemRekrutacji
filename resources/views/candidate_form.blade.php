@extends('layouts.app')

@section('content')
<div class="container" id="candidate_form">

    <h1 class="text-center h1">| {{ __('Formularz kandydata') }} |</h1>

    <form method="POST" action="{{route('addEdit')}}" enctype="multipart/form-data">
        @csrf
        <div class="accordion mt-5" id="accordionPanels">
            {{-- Poszukuję --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#looking_for" aria-expanded="true" aria-controls="looking_for">
                        {{ __('Poszukuję') }}
                    </button>
                </h2>
                <div id="looking_for" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <input type="hidden" name="position_manual" id="position_manual" value="{{ $user->position_manual }}">

                        {{-- Docelowe stanowisko --}}
                        <div class="input-group">
                            <label for="position_id" class="col-12 col-md-2 col-form-label">{{ __('Docelowe stanowisko') }}</label>
                            <div class="col-12 col-md-10">
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <div class="col-10 col-xl-11">
                                            <select class="form-select" id="position_id" {{ $disabled }} name="position_id" aria-label="{{ __('Docelowe stanowisko') }}" @if($user->position_manual == 1) disabled @endif>
                                                <option value="">{{ __('Wybierz') }}</option>
                                                @foreach ($filter['positions'] as $position)
                                                    <option @if($position->id == $user->position_id) selected @endif value="{{ $position->id }}" >{{ $position->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group-text col-2 col-xl-1">
                                          <input
                                              class="form-check-input mt-0 me-2"
                                              {{ $disabled }}
                                              onclick="onPositionCheckbox()"
                                              type="checkbox"
                                              id="position_checkbox"
                                              @if($user->position_manual == 1) checked @endif
                                              aria-label="{{ __('Trwa nadal') }}"
                                          >
                                          {{ __('Inne') }}
                                        </div>
                                    </div>
                                </div>
                                @isset($user->error['position_id'])
                                    <p class="text-danger fw-bold">
                                        {{ $user->error['position_id'] }}
                                    </p>
                                @endisset
                            </div>
                        </div>

                        {{-- Docelowe stanowisko inne --}}
                        <div class="mb-3 row {{ $user->position_manual == 0 ? 'd-none' : ''  }}" id="position_name_label">
                            <label for="position_name" class="col-12 col-md-2 col-form-label">{{ __('Podaj stanowisko') }}</label>
                            <div class="col-12 col-md-10">
                                <input type="text" {{ $disabled }} class="form-control" id="position_name" name="position_name" value="{{ isset($user->position_name) ? $user->position_name : '' }}">
                                @isset($user->error['position_name'])
                                    <p class="text-danger fw-bold">
                                        {{ $user->error['position_name'] }}
                                    </p>
                                @endisset
                            </div>
                        </div>

                        {{-- Lokalizacja --}}
                        <div class="mb-3 row">
                            <label for="location" class="col-12 col-md-2 col-form-label">{{ __('Lokalizacja') }}</label>
                            <div class="col-12 col-md-10">
                                <input type="text" {{ $disabled }} class="form-control" id="location" name="location" value="{{ isset($user->location) ? $user->location : '' }}">
                            </div>
                        </div>

                        {{-- Od kiedy mogę zacząć --}}
                        <div class="mb-3 row">
                            <label for="availability" class="col-12 col-md-2 col-form-label">{{ __('Dostępność') }}</label>
                            <div class="col-12 col-md-10">
                                <select class="form-select" {{ $disabled }} name="availability" aria-label="{{ __('Dostępność')}}">
                                    @foreach($filter['availability'] as $av)
                                        <option @if($av->id == $user->availability) selected @endif value="{{ $av->id }}">{{ $av->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Dane osobowe --}}
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#user" aria-expanded="true" aria-controls="user">
                    {{ __('Dane osobowe') }}
                </button>
              </h2>
              <div id="user" class="accordion-collapse collapse show">
                <div class="accordion-body">

                    {{-- Imię --}}
                    <div class="mb-3 row">
                        <label for="firstname" class="col-12 col-md-2 col-form-label">{{ __('Imię') }}</label>
                        <div class="col-12 col-md-10">
                            <input type="text" {{ $disabled }} class="form-control" id="firstname" name="firstname" value="{{ $user->firstname }}">
                            @isset($user->error['firstname'])
                                <p class="text-danger fw-bold">
                                    {{ $user->error['firstname'] }}!
                                </p>
                            @endisset
                        </div>
                    </div>

                    {{-- Nazwisko --}}
                    <div class="mb-3 row">
                        <label for="lastname" class="col-12 col-md-2 col-form-label">{{ __('Nazwisko') }}</label>
                        <div class="col-12 col-md-10">
                            <input type="text" {{ $disabled }} class="form-control" id="lastname" name="lastname" value="{{ $user->lastname }}">
                            @isset($user->error['lastname'])
                                <p class="text-danger fw-bold">
                                    {{ $user->error['lastname'] }}!
                                </p>
                            @endisset
                        </div>
                    </div>

                    {{-- Data urodzenia --}}
                    <div class="mb-3 row">
                        <label for="birthday" class="col-12 col-md-2 col-form-label">{{ __('Wiek') }}</label>
                        <div class="col-12 col-md-10">
                            <input type="date" {{ $disabled }} class="form-control" id="birthday" name="birthday" value="{{ $user->birthday }}">
                            @isset($user->error['birthday'])
                                <p class="text-danger fw-bold">
                                    {{ $user->error['birthday'] }}!
                                </p>
                            @endisset
                        </div>
                    </div>

                    {{-- Płeć --}}
                    <div class="mb-3 row">
                        <label for="sex" class="col-12 col-md-2 col-form-label">{{ __('Płeć') }}</label>
                        <div class="col-12 col-md-10">
                            <select class="form-select" {{ $disabled }} name="sex" aria-label="{{ __('Płeć')}}">
                                @foreach ($filter['sex'] as $sex)
                                    <option @if($user->sex == $sex->id) selected @endif value="{{ $sex->id }}">{{ $sex->name }}</option>
                                @endforeach
                            </select>
                            @isset($user->error['sex'])
                                <p class="text-danger fw-bold">
                                    {{ $user->error['sex'] }}!
                                </p>
                            @endisset
                        </div>
                    </div>

                    {{-- Adres e-mail --}}
                    <div class="mb-3 row">
                        <label for="email" class="col-12 col-md-2 col-form-label">{{ __('Email') }}</label>
                        <div class="col-12 col-md-10">
                            <input type="text" {{ $disabled }} readonly class="form-control-plaintext" id="email" name="email" value="{{ $user->email }}">
                            @isset($user->error['email'])
                                <p class="text-danger fw-bold">
                                    {{ $user->error['email'] }}!
                                </p>
                            @endisset
                        </div>
                    </div>

                    {{-- Numer telefonu --}}
                    <div class="mb-3 row">
                        <label for="phone" class="col-12 col-md-2 col-form-label">{{ __('Numer telefonu') }}</label>
                        <div class="col-12 col-md-10">
                            <input type="text" {{ $disabled }} class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                            @isset($user->error['phone'])
                                <p class="text-danger fw-bold">
                                    {{ $user->error['phone'] }}!
                                </p>
                            @endisset
                        </div>
                    </div>

                    {{-- Ulica --}}
                    <div class="mb-3 row">
                        <label for="street" class="col-12 col-md-2 col-form-label">{{ __('Ulica') }}</label>
                        <div class="col-12 col-md-10">
                            <input type="text" {{ $disabled }} class="form-control" id="street" name="street" value="{{ $user->street }}">
                            @isset($user->error['street'])
                                <p class="text-danger fw-bold">
                                    {{ $user->error['street'] }}!
                                </p>
                            @endisset
                        </div>
                    </div>

                    {{-- Numer domu --}}
                    <div class="mb-3 row">
                        <label for="street_number" class="col-12 col-md-2 col-form-label">{{ __('Numer domu') }}</label>
                        <div class="col-12 col-md-10">
                            <input type="number" {{ $disabled }} class="form-control" id="street_number" name="street_number" value="{{ $user->street_number }}">
                            @isset($user->error['street_number'])
                                <p class="text-danger fw-bold">
                                    {{ $user->error['street_number'] }}!
                                </p>
                            @endisset
                        </div>
                    </div>

                    {{-- Numer lokalu --}}
                    <div class="mb-3 row">
                        <label for="flat_number" class="col-12 col-md-2 col-form-label">{{ __('Numer lokalu') }}</label>
                        <div class="col-12 col-md-10">
                            <input type="number" {{ $disabled }} class="form-control" id="flat_number" name="flat_number" value="{{ $user->flat_number }}">
                            @isset($user->error['flat_number'])
                                <p class="text-danger fw-bold">
                                    {{ $user->error['flat_number'] }}!
                                </p>
                            @endisset
                        </div>
                    </div>

                    {{-- Zdjęcie --}}
                    <div class="mb-3 row">
                        <label for="image" class="col-12 col-md-2 col-form-label">{{ __('Zdjęcie') }}</label>
                        <div class="col-12 col-md-10">
                            @isset($user->image)
                                <img class="mb-3 img-fluid rounded" alt="{{ __('Zdjęcie profilowe') }}" style="width: 15rem; height: 15rem;" src="data:image/jpeg;base64,{{ $user->image }}" />
                            @endisset

                            @if(!$disabled)
                                <input type="file" name="image" class="form-control custom-file-input">
                                @isset($user->error['image'])
                                    <p class="text-danger fw-bold">
                                        {{ $user->error['image'] }}!
                                    </p>
                                @endisset
                            @endif
                        </div>
                    </div>
                </div>
              </div>
            </div>

            {{-- Doświadczenie zawodowe --}}
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#expirience" aria-expanded="true" aria-controls="expirience">
                    {{ __('Doświadczenie zawodowe') }}
                </button>
              </h2>
              <div id="expirience" class="accordion-collapse collapse show">
                    <input id="expirience_last" value="{{ $expirience['count'] }}" type="hidden" >
                    {!! $expirience['result'] !!}
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
                    <input id="education_last" value="{{ $education['count'] }}" type="hidden" >
                    {!! $education['result'] !!}
                </div>
            </div>

            {{-- Umiejętności i Kwalifikacje --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#skill" aria-expanded="true" aria-controls="skill">
                        {{ __('Umiejętności i Kwalifikacje') }}
                    </button>
                </h2>
                <div id="skill" class="accordion-collapse collapse show">
                    <input id="skill_last" value={{ $skill['count'] }} type="hidden" >
                    {!! $skill['result'] !!}
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
                    <input id="interests_last" value={{ $interests['count'] }} type="hidden" >
                    {!! $interests['result'] !!}
                </div>
            </div>

            {{-- Informacje dodatkowe --}}
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#additional_information" aria-expanded="true" aria-controls="additional_information">
                        {{ __('Dodatkowe informacje') }}
                    </button>
                </h2>
                <div id="additional_information" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="mb-3 row">
                            <label for="add_info" class="col-12 col-form-label">{{ __('Dodatkowe informacje') }}</label>
                            <textarea class="form-control col-12" {{ $disabled }}  name="add_info" id="add_info" rows="5">{{ isset($user->add_info) ? $user->add_info : '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            @if(!$disabled)
                <div class="container btn-lg">
                    <button type="submit" name="save" value="1" class="d-block mx-auto btn btn-primary addButton my-2 px-5 py-2">{{ __('Zapisz Formularz') }}</button>
                </div>
            @endif
    </form>
</div>
@endsection


@section('script')
<script type="module">
    $(document).ready(function() {
        $('.form-select').select2({
            width: '100%',
            height: '100%',
            placeholder: '{{ __('Wybierz') }}',
            allowClear: true,
        });
    });
</script>
@if(!$disabled)
    <script>
        function addNewExpirience() {
            const expirience = $('#expirience');

            const last = $('#expirience_last').val();
            $('#expirience_last').val(+last + 1);
            const index = $('#expirience_last').val();

            // Validation
            const limit = 5;
            const expirience_length = $('#expirience .accordion-body').length;

            if(expirience_length >= limit) {
                alert(`{{ __('Możesz dodać maksymalnie') }} ${limit} {{ __('doświadczeń zawodowych') }}`);
                return false;
            }

            expirience.append(`
                <div class="accordion-body border" index="${index}">
                    <input type="hidden" name="exp_id[]" value="" >
                    <input type="hidden" id="exp_in_progress${index}" name="exp_in_progress[]" value="">

                    <div class="row">
                        {{-- Start Date --}}
                        <div class="mb-3 row">
                            <label for="exp_start_date${index}" class="col-12 col-md-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
                            <div class="col-12 col-md-10">
                                <input type="date" class="form-control" id="exp_start_date${index}" name="exp_start_date[]" value="">
                            </div>
                        </div>

                        {{-- End Date --}}
                        <div class="mb-3 row">
                            <label for="end_date${index}" class="col-12 col-md-2 col-form-label">{{ __('Data zakończenia') }}</label>
                            <div class="col-12 col-md-10">
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="exp_end_date${index}" name="exp_end_date[]" value="">
                                        <div class="input-group-text">
                                            <input
                                                class="form-check-input mt-0 me-2"
                                                onclick="onCheckBoxChange('exp', ${index})"
                                                type="checkbox"
                                                id="exp_checkbox${index}"
                                                aria-label="{{ __('Trwa nadal') }}"
                                            >
                                            {{ __('Trwa nadal') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="mb-3 row">
                            <label for="exp_company_name${index}" class="col-12 col-md-2 col-form-label">{{ __('Nazwa firmy') }}</label>
                            <div class="col-12 col-md-10">
                                <input type="text" class="form-control" id="exp_company_name${index}" name="exp_company_name[]" value="">
                            </div>
                        </div>

                        {{-- Position --}}
                        <div class="mb-3 row">
                            <label for="exp_position${index}" class="col-12 col-md-2 col-form-label">{{ __('Stanowisko') }}</label>
                            <div class="col-12 col-md-10">
                            <input type="text" class="form-control" id="exp_position${index}" name="exp_position[]" value="">
                            </div>
                        </div>

                        {{-- Responsibilities --}}
                        <div class="mb-3 row">
                            <label for="exp_responsibilities${index}" class="col-12 col-form-label">{{ __('Zakres obowiązków') }}</label>
                            <textarea class="form-control col-12" name="exp_responsibilities[]" id="exp_responsibilities${index}" rows="5"></textarea>
                        </div>
                    </div>

                        <button type="button" class="btn btn-primary addButton" onclick="addNewExpirience()">{{ __('Dodaj Pozycję') }}</button>
                        <button type="button" class="btn btn-primary delButton" onclick="removePosition(${index})">{{ __('Usuń Pozycję') }}</button>
                </div>
            `);
        }

        function addNewEdu() {
            const educations = $('#education');

            const last = $('#education_last').val();
            $('#education_last').val(+last + 1);
            const index = $('#education_last').val()

            // Validation
            const limit = 5;
            const education_length = $('#education .accordion-body').length;

            if(education_length >= limit) {
                alert(`{{ __('Możesz dodać maksymalnie') }} ${limit} {{ __('wykształceń') }}`);
                return false;
            }

            educations.append(`
                <div class="accordion-body border" index="${index}">
                    <input type="hidden" name="edu_id[]" value="" >
                    <input type="hidden" id="edu_in_progress${index}" name="edu_in_progress[]" value="">

                    <div class="row">
                        {{-- Start Date --}}
                        <div class="mb-3 row">
                            <label for="edu_start_date${index}" class="col-12 col-md-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
                            <div class="col-12 col-md-10">
                                <input type="date" class="form-control" id="edu_start_date${index}" name="edu_start_date[]" value="">
                            </div>
                        </div>

                        {{-- End Date --}}
                        <div class="mb-3 row">
                            <label for="end_date${index}" class="col-12 col-md-2 col-form-label">{{ __('Data zakończenia') }}</label>
                            <div class="col-12 col-md-10">
                                <div class="input-group mb-3">
                                    <div class="input-group">
                                    <input type="date" class="form-control" id="edu_end_date${index}" name="edu_end_date[]" value="">
                                    <div class="input-group-text">
                                        <input
                                            class="form-check-input mt-0 me-2"
                                            onclick="onCheckBoxChange( 'edu' , ${index})"
                                            type="checkbox"
                                            id="edu_checkbox${index}"
                                            aria-label="{{ __('Trwa nadal') }}"
                                        >
                                        {{ __('Trwa nadal') }}
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Name --}}
                        <div class="mb-3 row">
                            <label for="edu_education_name${index}" class="col-12 col-md-2 col-form-label">{{ __('Nazwa uczelni') }}</label>
                            <div class="col-12 col-md-10">
                                <input type="text" class="form-control" id="edu_education_name${index}" name="edu_education_name[]" value="">
                            </div>
                        </div>

                        {{-- Major --}}
                        <div class="mb-3 row">
                            <label for="edu_major${index}" class="col-12 col-md-2 col-form-label">{{ __('Kierunek') }}</label>
                            <div class="col-12 col-md-10">
                            <input type="text" class="form-control" id="edu_major${index}" name="edu_major[]" value="">
                            </div>
                        </div>

                        {{-- Title --}}
                        <div class="mb-3 row">
                            <label for="edu_title${index}" class="col-12 col-md-2 col-form-label">{{ __('Tytuł') }}</label>
                            <div class="col-12 col-md-10">
                            <input type="text" class="form-control" id="edu_title${index}" name="edu_title[]" value="">
                            </div>
                        </div>
                    </div>

                        <button type="button" class="btn btn-primary addButton" onclick="addNewEdu()">{{ __('Dodaj Pozycję') }}</button>
                        <button type="button" class="btn btn-primary delButton" onclick="removePosition(${index})">{{ __('Usuń Pozycję') }}</button>
                </div>
            `);

        }

        function addNewSkill() {
            const skill = $('#skill');

            const last = $('#skill_last').val();
            $('#skill_last').val(+last + 1);
            const index = $('#skill_last').val();

            // Validation
            const limit = 10;
            const skill_length = $('#skill .accordion-body').length;

            if(skill_length >= limit) {
                alert(`{{ __('Możesz dodać maksymalnie') }} ${limit} {{ __('umiejętności') }}`);
                return false;
            }

            skill.append(`
                <div class="accordion-body border" index="${index}">
                    <input type="hidden" name="skill_id[]" value="" >

                    <div class="row">
                        <div class="mb-3 row">
                            <label for="skill_name${index}" class="col-12 col-md-2 col-form-label">{{ __('Nazwa umiejętności') }}</label>
                            <div class="col-12 col-md-10">
                                <input type="text" class="form-control" id="skill_name${index}" name="skill_name[]" value="">
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

            // Validation
            const limit = 10;
            const interests_length = $('#interests .accordion-body').length;

            if(interests_length >= limit) {
                alert(`{{ __('Możesz dodać maksymalnie') }} ${limit} {{ __('zainteresowań') }}`);
                return false;
            }

            interests.append(`
                <div class="accordion-body border" index="${index}">
                    <input type="hidden" name="int_id[]" value="" >

                    <div class="row">
                        <div class="mb-3 row">
                            <label for="int_name${index}" class="col-12 col-md-2 col-form-label">{{ __('Nazwa zainteresowania') }}</label>
                            <div class="col-12 col-md-10">
                                <input type="text" class="form-control" id="int_name${index}" name="int_name[]" value="">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary addButton" onclick="addNewInt()">{{ __('Dodaj Pozycję') }}</button>
                    <button type="button" class="btn btn-primary delButton" onclick="removePosition(${index})">{{ __('Usuń Pozycję') }}</button>
                </div>
            `);
        }

        function removePosition(index) {
            $(`.accordion-body[index="${index}"]`).remove();
        }

        function onCheckBoxChange(prefix, index) {
            const target = $('#' + prefix + '_in_progress' + index);
            const checked = $('#' + prefix + '_checkbox' + index).prop('checked');

            if(checked) {
                $('#' + prefix + '_end_date' + index).attr('readonly', true);
                $('#' + prefix + '_end_date' + index).val('');
            } else {
                $('#' + prefix + '_end_date' + index).attr("readonly", false);
            }

            target.val(checked ? 1 : 0);
        }

        function onPositionCheckbox() {
            const checked = $('#position_checkbox').prop('checked');
            const position_id = $('#position_id');
            const position_label = $('#position_name_label');
            const position_manual = $('#position_manual');
            const position_name = $('#position_name');

            $('#postion_manual').val(checked ? 1 : 0);

            if(checked) {
                position_manual.val(1);
                position_id.val(null).trigger('change');
                position_id.prop('disabled', true);
                position_label.removeClass('d-none');
            } else {
                position_manual.val(0);
                position_id.prop('disabled', false);
                position_label.addClass('d-none');
                position_name.val(null);
            }
        }
    </script>
@endif
@endsection
