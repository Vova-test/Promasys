@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Project card') }}</h4>
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
                        id="card-app"
                        data-url="{{ route('credentials', [$project['id']]) }}"
                    >
                        <div class="row my-4">
                            <div class="col my-auto">
                                <h6><strong>Credentials: @{{credentialSets.length}} sets</strong></h6>
                            </div>
                            <div class="col-auto ml-auto my-auto">
                                <button
                                    type="button"
                                    class="btn btn-success"
                                    @click="editOrCreateSet(`{{ route('credential.store') }}`, `{{ $project['id'] }}`)"
                                >
                                {{ __('Add new set') }}
                                </button>
                            </div>
                        </div>
                        <div
                            v-for="(credentialSet, index) of credentialSets"
                            class="mb-3"
                        >
                            <h6>@{{index + 1}}. @{{credentialSet.title}}</h6>
                            <div class="row mx-1">
                                <div class="col col-md-8 my-auto border border-dark">
                                    <pre>@{{ credentialSet.credentials }}</pre>
                                </div>
                                <div class="col-auto my-auto">
                                    <button
                                        type="button"
                                        class="btn btn-success"
                                        @click="editOrCreateSet(
                                            `{{route('credential.update',['id'])}}`,
                                            `{{ $project['id'] }}`,
                                            credentialSet
                                        )"
                                        v-if="`{{ $project['type'] }}` > 1"
                                    >Edit</button>
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        @click="deleteSet(
                                            `{{route('credential.delete', ['id'])}}`,
                                            credentialSet.id,
                                            credentialSet.title
                                        )"
                                        v-if="`{{ $project['type'] }}` > 1"
                                    >Delete</button>
                                </div>
                            </div>
                        </div>
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

                        <!-- Modal -->
                        <div class="modal fade show"
                             tabindex="-1"
                             role="dialog"
                             id="modalCredentialSet"
                        >
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">
                                            Create a new set
                                        </h5>
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="modal"
                                            aria-label="Close"
                                        >
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Credential Title</label>
                                            <input
                                                type="email"
                                                class="form-control"
                                                placeholder="title"
                                                v-model="credentialSet.title"
                                            >
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Credentias</label>
                                            <textarea
                                                class="form-control"
                                                rows="3"
                                                v-model="credentialSet.credentials"
                                            ></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            @click="updateOrStoreSet()"
                                        >
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
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
    <script src="{{ asset('js/card.js') }}" defer></script>
@endpush
