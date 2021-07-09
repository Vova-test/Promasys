@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Settings') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col my-auto">
                            <h3>{{ $project['name'] }}</h3>
                        </div>
                        <div class="col-auto ml-auto my-auto">
                            <a
                                type="button"
                                class="btn btn-primary"
                                href="{{ route('settings', [$project['id']]) }}"
                            >
                            {{ __('Settings') }}
                            </a>
                        </div>
                    </div>
                    <h6>
                        {{ $project['description'] }}
                    </h6>
                    <div
                        id="setting-app"
                        data-url="{{ route('settings', [$project['id']]) }}"
                    >

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="{{ asset('js/card.js') }}" defer></script>
@endpush
