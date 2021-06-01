@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="container" id="project-app">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Your Projects') }}</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <ul
                                v-if="logs.length != 0"
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
                                v-if="errors.length != 0"
                                v-for="error of errors"
                                class="list-group my-1"
                            >
                                <li class="list-group-item list-group-item-danger">
                                    @{{error}}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col">
                            <button
                                type="button"
                                class="btn btn-success"
                                @click="modalVisibility = true"
                            >
                                Create
                            </button>
                        </div>
                        <div class="col-md4 ml-auto">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-search"></i> </span>
                                    </div>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="search"
                                        v-model="search"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-hover table-responsive-sm">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">{{ __('#') }}</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Description') }}</th>
                            <th scope="col">{{ __('Logo') }}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(userProject, index) of filteredUserProjects"
                                @click="selectProject(index)"
                                :class="{'table-primary' : selectedProjectIndex === index}"
                            >
                                <th scope="row"  class="align-middle">@{{index+1}}</th>
                                <td  class="align-middle">@{{userProject.project.name}}</td>
                                <td  class="align-middle">@{{userProject.project.description}}</td>
                                <td  class="align-middle"><span v-if="userProject.type === 1">You are owner</span></td>
                                <td  class="align-middle">
                                    <button
                                        type="button"
                                        class="btn btn-info text-light"
                                    >
                                        Open
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-success"
                                        @click="editProject(userProject.project)"
                                        v-if="userProject.type === 1"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        @click="deleteProject(userProject.project.id)"
                                        v-if="userProject.type === 1"
                                    >
                                        Delete
                                    </button>
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary  btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            {{ __('Actions') }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="/project/edit/{{'$projects->id'}}">{{ __('Edit') }}</a></li>
                                            <li><a href="/project/delete/{{'$projects->id'}}">{{ __('Delete') }}</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->

    <transition name="modal-store">
        <div class="modal fade show"
             tabindex="-1"
             role="dialog"
             v-if="modalVisibility"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">
                            Do you want to @{{(project.id) ? 'change the' : 'create a new'}} project?
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            @click="modalVisibility = false;"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email address</label>
                            <input
                                type="email"
                                class="form-control"
                                placeholder="name"
                                v-model="project.name"
                            >
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Example textarea</label>
                            <textarea
                                class="form-control"
                                rows="3"
                                v-model="project.description"
                            ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Example file input</label>
                            <input
                                type="file"
                                class="form-control-file"
                            >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="saveProject(project.id)"
                        >
                            Save project
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <transition name="fade">
        <div class="modal-backdrop fade show" v-if="modalVisibility"></div>
    </transition>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="{{ asset('js/project.js') }}" defer></script>
@endpush
