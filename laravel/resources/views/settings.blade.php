@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div
    class="container"
    id="setting-app"
    data-url="{{ route('settings.list', [$project['id']]) }}"
>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Settings') }}</h4>
                </div>
                <div class="card-body">
                    <h1>{{ $project['name'] }}</h1>
                    <h4>{{ __('Users who have access:') }}</h4>
                    <ul class="list-group">
                        <li
                            v-if="userSettings.length == 0"
                            class="list-group-item text-info"
                        >
                            <h4>{{ __('Nobody have got the project access, except owner!') }}</h4>
                        </li>
                        <li
                            class="
                                list-group-item
                                d-flex
                                justify-content-between
                                align-items-center"
                            v-for="(userSetting, index) of userSettings"
                        >
                            @{{userSetting.name}} (@{{projectAccess[userSetting.type]}})
                            <button
                                type="button"
                                class="btn btn-link"
                                @click="deleteSetting(
                                    `{{ route('settings.delete', ['id']) }}`,
                                    userSetting.userProjectId,
                                    userSetting.name
                                )"
                            >
                                delete
                            </button>
                        </li>
                    </ul>
                    <div
                        class="d-sm-flex justify-content-between align-items-center mt-4"
                        v-if="users.length > 0"
                    >
                        <h4>{{ __('User name:') }}</h4>
                        <select
                            class="form-control-lg"
                            v-model="userId"
                        >
                            <option
                                v-for="(user, index) of users"
                                :value="user.id"
                            >
                                @{{user.name}}
                            </option>
                        </select>
                        <div class="form-check form-switch form-check-inline ml-2">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="flexSwitchCheckChecked"
                                v-model="checked"
                            >
                            <label class="form-check-label" for="flexSwitchCheckChecked">extended access</label>
                        </div>
                        <div class="d-flex justify-content-center mt-2 mt-sm-0">
                            <button
                                class="btn btn-secondary"
                                @click="setSetting(`{{ route('settings.store') }}`,`{{ $project['id'] }}`)"
                            >
                                {{ __('Grant') }}
                            </button>
                        </div>
                    </div>
                    <div
                        v-if="users.length == 0"
                        class="text-info mt-3"
                    >
                        <h4>{{ __('There is no one to get access to the project!') }}</h4>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12">
                            <ul
                                v-for="log of logs"
                                class="list-group my-1"
                            >
                                <li class="list-group-item list-group-item-success">
                                    @{{log}}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <ul
                                v-for="error of errors"
                                class="list-group my-1"
                            >
                                <li class="list-group-item list-group-item-danger">
                                    @{{error}}
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="{{ asset('js/setting.js') }}" defer></script>
@endpush
