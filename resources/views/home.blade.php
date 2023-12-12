@extends('layouts.app')

@section('content')
<div class="container">
    <form method="GET" action={{ route('recruterHome') }}>
        <div class="row">
            <div class="col-md-6">
                {{-- Username --}}
                <div class="form-group">
                    <label for="username" class="col-form-label">{{ __('Imię i nazwisko') }}:</label>
                    <select class="form-select" id="username" name="username[]" multiple>
                        @foreach ($filter['users'] as $username)
                            <option
                                @if(isset($selected['username']) && in_array($username->id, $selected['username'])) selected @endif
                                value="{{ $username->id }}"
                            >
                                {{ $username->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Age --}}
                <div class="form-group mt-2">
                    <label for="age" class="col-form-label">{{ __('Wiek') }}:</label>
                    <input
                        type="number"
                        class="form-control"
                        id="age"
                        name="age"
                        value="@if(isset($selected['age'])){{ $selected['age'] }}@endif"
                    >
                </div>

                {{-- Sex --}}
                <div class="form-group mt-2">
                    <label for="sex" class="col-form-label">{{ __('Płeć') }}:</label>
                    <select class="form-select" id="sex" name="sex">
                        <option @if(isset($selected['sex']) && $selected['sex'] == 1 ) selected @endif value="1">{{ __('Mężczyzna') }}</option>
                        <option @if(isset($selected['sex']) && $selected['sex'] == 2 ) selected @endif value="2">{{ __('Kobieta') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                {{-- Target Position --}}
                <div class="form-group">
                    <label for="position" class="col-form-label">{{ __('Oczekiwane stanowisko') }}:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="position"
                        name="position"
                        value="@if(isset($selected['position'])){{ $selected['position'] }}@endif"
                    >
                </div>

                {{-- City --}}
                <div class="form-group mt-2">
                    <label for="city" class="col-form-label">{{ __('Miasto') }}:</label>
                    <select class="form-select" multiple id="city" name="city[]">
                        @foreach($filter['city'] as $city)
                            <option @if(isset($selected['city']) && in_array($city->id, $selected['city'])) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Phone --}}
                <div class="form-group mt-2">
                    <label for="phone" class="col-form-label">{{ __('Numer telefonu') }}:</label>
                    <select class="form-select" multiple id="phone" name="phone[]">
                        @foreach($filter['phone'] as $phone)
                            <option @if(isset($selected['phone']) && in_array($phone->id, $selected['phone'])) selected @endif value="{{ $phone->id }}">{{ $phone->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Start From --}}
                <div class="form-group mt-2">
                    <label for="availability" class="col-form-label">{{ __('Dostępność') }}</label>
                    <select class="form-select" multiple name="availability[]" aria-label="{{ __('Dostępność')}}">
                        <option @if(isset($selected['availability']) && in_array(1, $selected['availability'])) selected @endif value="1">{{ __('Miesiąc') }}</option>
                        <option @if(isset($selected['availability']) && in_array(2, $selected['availability'])) selected @endif value="2">{{ __('2 Miesiące') }}</option>
                        <option @if(isset($selected['availability']) && in_array(3, $selected['availability'])) selected @endif value="3">{{ __('3 Miesiące') }}</option>
                    </select>
                </div>

            </div>

            <div>
                <button type="submit" class="btn btn-primary">{{ __('Filtruj') }}</button>
                <a href="{{ route('recruterHome') }}" class="btn btn-outline-primary">{{  __('Resetuj') }}</a>
            </div>
        </div>
    </form>

    <h1 class="text-center h1 mt-5">| {{ __('Lista kandydatów') }} |</h1>

    @if($users)
    <div class="table-responsive">
        <table class="table table-striped border mt-5">
            <thead>
                <tr>
                    <th>{{ __('Imię i nazwisko') }}</th>
                    <th>{{ __('Wiek') }}</th>
                    <th>{{ __('Płeć') }}</th>
                    <th>{{ __('Docelowe stanowisko') }}</th>
                    <th>{{ __('Miasto') }}</th>
                    <th>{{ __('Numer telefonu') }}</th>
                    <th>{{ __('Od kiedy mogę zacząć') }}</th>
                    <th>{{ __('Akcje') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->age }}</td>
                        <td>{{ $user->sex }}</td>
                        <td>{{ $user->position }}</td>
                        <td>{{ $user->city }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->availability }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('addEdit', ['id' => $user->id]) }}">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        {{ $users->links('pagination::bootstrap-5') }}
    @endif
</div>
@endsection

@section('script')
<script type="module">
    $(document).ready(function() {
        $('.form-select').select2({
            placeholder: '{{ __('Wybierz') }}',
            allowClear: true,
        });
    });
</script>
@endsection
