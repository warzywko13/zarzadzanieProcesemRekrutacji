<div class="accordion-body border" index="{{ $index }}" id="{{ isset($exp) ? $exp->id : '' }}">
    <div class="row">
        <div class="mb-3 row">
            <label for="start_date_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" id="start_date_{{ $index }}" name="start_date[]" value="">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="end_date_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Data zakończenia') }}</label>
            <div class="col-sm-10">
              <div class="input-group mb-3">
                <div class="input-group">
                  <input type="date" class="form-control" id="end_date_{{ $index }}" name="end_date[]" value="{{ isset($exp) ? $exp->end_date : '' }}">
                  <div class="input-group-text">
                    <input class="form-check-input mt-0 me-2" type="checkbox" value="{{ isset($exp) ? $exp->in_progress : '' }}" aria-label="{{ __('Trwa nadal') }}">
                    {{ __('Trwa nadal') }}
                  </div>
                </div>
              </div>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="company_name_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Nazwa firmy') }}</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="company_name_{{ $index }}" name="company_name[]" value="{{ isset($exp) ? $exp->name : '' }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="position_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Stanowisko') }}</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="position_{{ $index }}" name="position[]" value="{{ isset($exp) ? $exp->position : '' }}">
            </div>
        </div>

        <div class="mb-3 row">
          <label for="responsibilities_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Zakres obowiązków') }}</label>
          <textarea class="form-control" name="responsibilities[]" id="responsibilities_{{ $index }}" rows="5"></textarea>
        </div>
    </div>
    <button type="button" class="btn btn-primary addButton" onclick="addNewPosition()">{{ __('Dodaj Pozycję') }}</button>
    @if($index !== 0)
        <button type="button" class="btn btn-primary delButton" onclick="removePosition({{ $index }})">{{ __('Usuń Pozycję') }}</button>
    @endif

</div>
