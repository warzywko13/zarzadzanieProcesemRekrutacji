@extends('layouts.app')

@section('content')
<div class="container">

    <form method="GET" action="{{ route('recruterPosition') }}">
        <div class="row">
            <div class="col-md-6">
                {{-- Position name --}}
                <div class="form-group">
                    <label for="position" class="col-form-label">{{ __('Nazwa stanowiska') }}:</label>
                    <select class="form-select" id="position" name="position[]" multiple>
                        @foreach($filter['positions'] as $position)
                            <option @if(isset($selected['position']) && in_array($position->id, $selected['position'])) selected @endif  value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                {{-- Create date --}}
                <div class="form-group">
                    <label for="created_at" class="col-form-label">{{ __('Data utworzenia') }}:</label>
                    <input type="date" class="form-control" id="created_at" name="created_at" value="{{ isset($selected['created_at']) ? $selected['created_at'] : '' }}">
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">{{ __('Filtruj') }}</button>
                <a href="{{ route('recruterPosition') }}" class="btn btn-outline-primary">{{  __('Resetuj') }}</a>
            </div>
        </div>
    </form>

    <h1 class="text-center h1 mt-5">| {{ __('Lista stanowisk') }} |</h1>

    <div class="d-flex flex-row-reverse mt-4">
        <a href="{{ route('addEditPosition') }}" class="btn btn-outline-primary">{{ __('Dodaj') }}</a>
    </div>

    @if($positions)
        <div class="table-responsive">
            <table class="table table-striped border mt-3">
                <thead>
                    <th class="col-md-7">{{ __('Nazwa stanowiska') }}</th>
                    <th class="col-md-3">{{ __('Data utworzenia') }}</th>
                    <th class="col-md-2">{{ __('Akcje') }}</th>
                </thead>
                <tbody>
                    @foreach ($positions as $position)
                        <tr>
                            <td>{{ $position->name }}</td>
                            <td>{{ date('d-m-Y', strtotime($position->created_at)) }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('addEditPosition', ['id' => $position->id]) }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a class="btn btn-primary" onclick="confirmDelete({{ $position->id }})">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $positions->links('pagination::bootstrap-5') }}
    @endif
</div>
@endsection

@section('script')
<script type="module">
    $(document).ready(function() {
        $('.form-select').select2({
            width: '100%',
            placeholder: '{{ __('Wybierz') }}',
            allowClear: true,
        });
    });
</script>
<script>
    function confirmDelete(positionId) {
        const confirmMessage = '{{ __('Czy napewno chcesz usunąć tą pozycję?') }}';

        if(confirm(confirmMessage)) {
            window.location.href="{{ route('deletePosition', ['id' => ':id']) }}".replace(':id', positionId);
        }
    }
</script>
@endsection
