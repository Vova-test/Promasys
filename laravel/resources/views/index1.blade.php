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
                    <div class="row px-3">
                        <div class="col pl-0 mb-1">
                            <button
                                type="button"
                                class="btn btn-success"
                                @click="editOrCreate()"
                            >
                                 <span

                                     data-placement="top"
                                     data-toggle="tooltip"
                                     title="Create a new project"
                                 >
                                    Create a new project
                                 </span>
                            </button>
                        </div>
                        <div class="col-md4 ml-auto mb-1">
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
                    <table class="table table-bordered table-striped table-hover table-responsive-sm">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">{{ __('#') }}</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Description') }}</th>
                            <th scope="col">{{ __('Project access') }}</th>
                            <th scope="col" {{--style="width: 10%"--}}>{{ __('Actions') }}</th>
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
                                <td class="align-middle"><span v-if="userProject.type === 1">You are owner</span></td>
                                <td class="align-middle text-right">
                                    <span
                                        data-toggle="tooltip"
                                        data-placement="auto"
                                        title="Show project"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-block fa fa-eye mb-1"
                                        >
                                        </button>
                                    </span>
                                    <span

                                        data-placement="top"
                                        data-toggle="tooltip"
                                        title="Edit project"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-success btn-block fas fa-pencil-alt mb-1"
                                            @click="editOrCreate(userProject.project)"
                                            v-if="userProject.type === 1"
                                        >
                                        </button>
                                    </span>
                                    <span

                                        data-placement="top"
                                        data-toggle="tooltip"
                                        title="Delete project"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-block fas fa-trash-alt"
                                            @click="deleteProject(userProject.project.id)"
                                            v-if="userProject.type === 1"
                                        >
                                        </button>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade show"
         tabindex="-1"
         role="dialog"
         id="modalProject"
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
                            ref="inputFile"
                            @change="getImage"
                            class="form-control-file"
                        >
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="updateOrStore(project.id)"
                    >
                        Save project
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="{{ asset('js/project.js') }}" defer></script>
@endpush
