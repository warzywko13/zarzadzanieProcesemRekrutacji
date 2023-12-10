<div class="accordion-body border" index="{{ $index }}">
    <input type="hidden" name="int_id[]" value="{{ isset($int) ? $int->id : '' }}" >

    <div class="row">
        <div class="mb-3 row">
            <label for="int_name_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Nazwa zainteresowania') }}</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="int_name_{{ $index }}" name="int_name[]" value="{{ isset($int->name) ? $int->name : '' }}">
                @isset($int->error['name'])
                    <p class="text-danger fw-bold">
                        {{ $int->error['name'] }}
                    </p>
                @endisset
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary addButton" onclick="addNewInt()">{{ __('Dodaj Pozycję') }}</button>
    @if($index != 0)
        <button type="button" class="btn btn-primary delButton" onclick="removePosition({{ $index }})">{{ __('Usuń Pozycję') }}</button>
    @endif
</div>
