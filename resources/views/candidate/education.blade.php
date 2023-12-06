<div class="accordion-body border" index="{{ $index }}">
    <input type="hidden" name="edu_id[]" value="{{ isset($edu) ? $edu->id : '' }}" >
    <input type="hidden" id="edu_in_progress_{{ $index }}" name="edu_in_progress[]" value="{{ isset($edu->in_progress) ? $edu->in_progress : '' }}">

    <div class="row">
        <div class="mb-3 row">
            <label for="edu_start_date_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" id="edu_start_date_{{ $index }}" name="edu_start_date[]" value="{{ isset($edu->start_date) ? date('Y-m-d', strtotime($edu->start_date)) : '' }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="end_date_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Data zakończenia') }}</label>
            <div class="col-sm-10">
              <div class="input-group mb-3">
                <div class="input-group">
                  <input type="date" class="form-control" @if(isset($edu->in_progress) && $edu->in_progress == 1) aria-disabled="true" @endif  id="edu_end_date_{{ $index }}" name="edu_end_date[]" value="{{ isset($edu->end_date) ? date('Y-m-d', strtotime($edu->end_date)) : '' }}">
                  <div class="input-group-text">
                    <input
                        class="form-check-input mt-0 me-2"
                        onclick="onCheckBoxChange( 'edu' , {{ $index }})"
                        type="checkbox"
                        id="edu_checkbox_{{ $index }}"
                        @if(isset($edu->in_progress) && $edu->in_progress == 1) checked @endif
                        aria-label="{{ __('Trwa nadal') }}"
                    >
                    {{ __('Trwa nadal') }}
                  </div>
                </div>
              </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="edu_education_name_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Nazwa uczelni') }}</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="edu_education_name_{{ $index }}" name="edu_education_name[]" value="{{ isset($edu) ? $edu->name : '' }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="edu_education_name_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Kierunek') }}</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="edu_education_name_{{ $index }}" name="edu_education_name[]" value="{{ isset($edu) ? $edu->name : '' }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="edu_title_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Tytuł') }}</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="edu_title_{{ $index }}" name="edu_title[]" value="{{ isset($edu) ? $edu->title : '' }}">
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary addButton" onclick="addNewEdu()">{{ __('Dodaj Pozycję') }}</button>
    @if($index != 0)
        <button type="button" class="btn btn-primary delButton" onclick="removePosition({{ $index }})">{{ __('Usuń Pozycję') }}</button>
    @endif

</div>