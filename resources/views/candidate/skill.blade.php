<div class="accordion-body border" index="{{ $index }}">
    <input type="hidden" name="skill_id[]" value="{{ isset($skill) ? $skill->id : '' }}" >

    <div class="row">
        <div class="mb-3 row">
            <label for="skill_name_{{ $index }}" class="col-sm-2 col-form-label">{{ __('Nazwa umiejętności') }}</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="skill_name_{{ $index }}" name="skill_name[]" value="{{ isset($skill->name) ? $skill->name : '' }}">
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary addButton" onclick="addNewSkill()">{{ __('Dodaj Pozycję') }}</button>
    @if($index != 0)
        <button type="button" class="btn btn-primary delButton" onclick="removePosition({{ $index }})">{{ __('Usuń Pozycję') }}</button>
    @endif
</div>
