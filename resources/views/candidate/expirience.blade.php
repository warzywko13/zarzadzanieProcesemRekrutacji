<div class="accordion-body border" index="{{ $index }}">
    <input type="hidden" name="exp_id[]" value="{{ isset($exp) ? $exp->id : '' }}" >
    <input type="hidden" id="exp_in_progress_{{ $index }}" name="exp_in_progress[]" value="{{ isset($exp->in_progress) ? $exp->in_progress : '' }}">

    <div class="row">
        <div class="mb-3 row">
            <label for="exp_start_date_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Data rozpoczęcia') }}</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="exp_start_date_{{ $index }}" name="exp_start_date[]" value="{{ isset($exp->start_date) ? date('Y-m-d', strtotime($exp->start_date)) : '' }}">
                @isset($exp->error['start_date'])
                    <p class="text-danger fw-bold">
                        {{ $exp->error['start_date'] }}!
                    </p>
                @endisset
            </div>
        </div>

        <div class="mb-3 row">
            <label for="end_date_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Data zakończenia') }}</label>
            <div class="col-sm-10">
                <div class="input-group mb-3">
                    <div class="input-group">
                    <input type="date" class="form-control" @if(isset($exp->in_progress) && $exp->in_progress == 1) aria-disabled="true" @endif  id="exp_end_date_{{ $index }}" name="exp_end_date[]" value="{{ isset($exp->end_date) ? date('Y-m-d', strtotime($exp->end_date)) : '' }}">
                    <div class="input-group-text">
                        <input
                            class="form-check-input mt-0 me-2"
                            onclick="onCheckBoxChange('exp', {{ $index }})"
                            type="checkbox"
                            id="exp_checkbox_{{ $index }}"
                            @if(isset($exp->in_progress) && $exp->in_progress == 1) checked @endif
                            aria-label="{{ __('Trwa nadal') }}"
                        >
                        {{ __('Trwa nadal') }}
                    </div>
                    </div>
                </div>
                @isset($exp->error['end_date'])
                    <p class="text-danger fw-bold">
                        {{ $exp->error['end_date'] }}!
                    </p>
                @endisset
            </div>
        </div>

        <div class="mb-3 row">
            <label for="exp_company_name_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Nazwa firmy') }}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="exp_company_name_{{ $index }}" name="exp_company_name[]" value="{{ isset($exp) ? $exp->name : '' }}">
                @isset($exp->error['name'])
                    <p class="text-danger fw-bold">
                        {{ $exp->error['name'] }}!
                    </p>
                @endisset
            </div>
        </div>

        <div class="mb-3 row">
            <label for="exp_position_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Stanowisko') }}</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="exp_position_{{ $index }}" name="exp_position[]" value="{{ isset($exp) ? $exp->position : '' }}">
            </div>
        </div>

        <div class="mb-3 row">
          <label for="exp_responsibilities_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Zakres obowiązków') }}</label>
          <textarea class="form-control" name="exp_responsibilities[]" id="exp_responsibilities_{{ $index }}" rows="5"></textarea>
        </div>
    </div>
    <button type="button" class="btn btn-primary addButton" onclick="addNewPosition()">{{ __('Dodaj Pozycję') }}</button>
    @if($index != 0)
        <button type="button" class="btn btn-primary delButton" onclick="removePosition({{ $index }})">{{ __('Usuń Pozycję') }}</button>
    @endif

</div>
