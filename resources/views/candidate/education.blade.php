<div class="accordion-body border" index="{{ $index }}">
    <input type="hidden" name="edu_id[]" value="{{ isset($edu) ? $edu->id : '' }}" >
    <input type="hidden" id="edu_in_progress{{ $index }}" name="edu_in_progress[]" value="{{ isset($edu->in_progress) ? $edu->in_progress : '' }}">

    <div class="row">
        {{-- Start Date --}}
        <div class="mb-3 row">
            <label for="edu_start_date{{ $index }}" class="col-12 col-md-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
            <div class="col-12 col-md-10">
                <input type="date" {{ $disabled }} class="form-control" id="edu_start_date{{ $index }}" name="edu_start_date[]" value="{{ isset($edu->start_date) ? date('Y-m-d', strtotime($edu->start_date)) : '' }}">

                @isset($edu->error['start_date'])
                    <p class="text-danger fw-bold">
                        {{ $edu->error['start_date'] }}!
                    </p>
                @endisset
            </div>
        </div>

        {{-- End Date --}}
        <div class="mb-3 row">
            <label for="edu_end_date{{ $index }}" class="col-12 col-md-2 col-form-label">{{ __('Data zakończenia') }}</label>
            <div class="col-12 col-md-10">
                <div class="input-group mb-3">
                    <div class="input-group">
                    <input type="date" {{ $disabled }} {{ isset($edu->in_progress) && $edu->in_progress == 1 ? 'disabled' : '' }} class="form-control" @if(isset($edu->in_progress) && $edu->in_progress == 1) aria-disabled="true" @endif  id="edu_end_date{{ $index }}" name="edu_end_date[]" value="{{ isset($edu->end_date) ? date('Y-m-d', strtotime($edu->end_date)) : '' }}">
                    <div class="input-group-text">
                        <input
                            class="form-check-input mt-0 me-2"
                            {{ $disabled }}
                            onclick="onCheckBoxChange( 'edu' , {{ $index }})"
                            type="checkbox"
                            id="edu_checkbox{{ $index }}"
                            @if(isset($edu->in_progress) && $edu->in_progress == 1) checked @endif
                            aria-label="{{ __('Trwa nadal') }}"
                        >
                        {{ __('Trwa nadal') }}
                    </div>
                    </div>
                </div>
                @isset($edu->error['end_date'])
                    <p class="text-danger fw-bold">
                        {{ $edu->error['end_date'] }}!
                    </p>
                @endisset
            </div>
        </div>

        {{-- Name --}}
        <div class="mb-3 row">
            <label for="edu_education_name{{ $index }}" class="col-12 col-md-2 col-form-label">{{ __('Nazwa uczelni') }}</label>
            <div class="col-12 col-md-10">
                <input type="text" {{ $disabled }} class="form-control" id="edu_education_name{{ $index }}" name="edu_education_name[]" value="{{ isset($edu) ? $edu->name : '' }}">
                @isset($edu->error['name'])
                    <p class="text-danger fw-bold">
                        {{ $edu->error['name'] }}
                    </p>
                @endisset
            </div>
        </div>

        {{-- Major --}}
        <div class="mb-3 row">
            <label for="edu_major{{ $index }}" class="col-12 col-md-2 col-form-label">{{ __('Kierunek') }}</label>
            <div class="col-12 col-md-10">
              <input type="text" {{ $disabled }} class="form-control" id="edu_major{{ $index }}" name="edu_major[]" value="{{ isset($edu) ? $edu->major : '' }}">
            </div>
        </div>

        {{-- Title --}}
        <div class="mb-3 row">
            <label for="edu_title{{ $index }}" class="col-12 col-md-2 col-form-label">{{ __('Tytuł') }}</label>
            <div class="col-12 col-md-10">
              <input type="text" {{ $disabled }} class="form-control" id="edu_title{{ $index }}" name="edu_title[]" value="{{ isset($edu) ? $edu->title : '' }}">
            </div>
        </div>
    </div>

    @if(!$disabled)
        <button type="button" class="btn btn-primary addButton" onclick="addNewEdu()">{{ __('Dodaj Pozycję') }}</button>
        @if($index != 0)
            <button type="button" class="btn btn-primary delButton" onclick="removePosition({{ $index }})">{{ __('Usuń Pozycję') }}</button>
        @endif
    @endif

</div>
