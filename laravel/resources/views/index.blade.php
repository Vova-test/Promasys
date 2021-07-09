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
                                @click="editOrCreate(`{{route('project.store')}}`)"
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
                        <div class="col-md-4 ml-auto mb-1">
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
                            <th scope="col">{{ __('Logo') }}</th>
                            <th scope="col">{{ __('Project access') }}</th>
                            <th scope="col" class="text-center">{{--{{ __('Actions') }}--}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(userProject, index) of filteredUserProjects"
                                @click="selectProject(index)"
                                :class="{'table-primary' : selectedProjectIndex === index}"
                            >
                                <th scope="row"  class="align-middle">@{{index+1}}</th>
                                <td  class="align-middle">@{{userProject.project.name}}</td>
                                <td  class="align-middle">
                                    <img
                                        v-if="userProject.project.logo"
                                        :src="`/storage/${userProject.project.logo}`"
                                        alt="LOGO"
                                        height="50"
                                        {{--width="50"--}}
                                    >
                                </td>
                                <td class="align-middle">
                                    @{{projectAccess[userProject.type]}}
                                </td>
                                <td class="align-middle text-right">
                                    <a
                                        type="button"
                                        class="btn btn-primary"
                                            :href="getRoute(
                                                `{{route('project.card', ['id'])}}`, userProject.project.id)"
                                    >
                                         <span
                                             data-toggle="tooltip"
                                             data-placement="auto"
                                             title="Show project"
                                             class="fa fa-eye"
                                         >
                                         </span>
                                    </a>
                                    <button
                                        type="button"
                                        class="btn btn-success my-1"
                                        @click="editOrCreate(
                                            `{{route('project.update', ['id'])}}`, userProject.project)"
                                        v-if="userProject.type === 3"
                                    >
                                        <span
                                            data-placement="top"
                                            data-toggle="tooltip"
                                            title="Edit project"
                                            class="fas fa-pencil-alt"
                                        >
                                        </span>
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        @click="deleteProject(`{{route('project.delete', ['id'])}}`, userProject.project.id)"
                                        v-if="userProject.type === 3"
                                    >
                                        <span
                                            data-placement="top"
                                            data-toggle="tooltip"
                                            title="Delete project"
                                            class="far fa-trash-alt"
                                        >
                                        </span>
                                    </button>
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
                        aria-label="Close"
                        @click="closeModal()"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Name">Project Name</label>
                        <input
                            id="Name"
                            type="email"
                            class="form-control"
                            placeholder="name"
                            v-model="project.name"
                        >
                    </div>
                    <div class="form-group">
                        <label for="Description">Project Description</label>
                        <textarea
                            id="Description"
                            class="form-control"
                            rows="3"
                            v-model="project.description"
                        ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Logo">Logo</label>
                        <input
                            id="Logo"
                            type="file"
                            ref="inputFile"
                            @change="getImage"
                            class="form-control-file"
                        >
                    </div>
                    <img
                        v-if="imageUrl || project.logo"
                        :src="imageUrl ? imageUrl : `/storage/${project.logo}`"
                        class="logo"
                    >
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="updateOrStore()"
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
