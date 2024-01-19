@extends('projects.layout')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Projects CRUD (Create, Read, Update and Delete)</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{url('/')}}" title="Home"><button class="btn btn-secondary"><i class="bi bi-house-door" aria-hidden="true"></i> Home</button></a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProject"><i class="bi bi-plus-lg" aria-hidden="true"></i>
                                Add Project
                            </button>
                        </div>
                        <!-- Create Modal -->
                        <div class="modal fade" id="createProject" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="createModalLabel">Add Project</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="storeProject" class="needs-validation" novalidate>
                                        <div class="modal-body">
                                        {!! csrf_field() !!}
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control form-input" id="name" name="name" required>
                                                <div class="invalid-feedback" id="name-feedback">
                                                    Please provide a name.
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control form-input" id="id" name="id" value="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Create Modal -->
                        <div class="modal fade" id="viewProject" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="projectModalLabel">Project Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Project Name -->
                                        <p><strong>Name:</strong> <span id="projectName">[Project Name Here]</span></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this project?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Delete Modal -->
                        <div class="modal fade" id="availableMembersModal" tabindex="-1" aria-labelledby="availableMembersModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="availableMembersModalLabel">Project Members</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <ul id="membersCheckboxList" class="list-group">
                                            @foreach($members as $member)
                                                <li class="list-group-item">
                                                    <input type="checkbox" value="{{ $member->id }}" id="checkbox{{ $member->id }}" class="modal-checkbox">
                                                    <label for="checkbox{{ $member->id }}">
                                                        {{ $member->first_name }} {{ $member->last_name }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="assignMembers">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $item)
                                    <tr>
                                        <td class="id">{{ $item->id }}</td>
                                        <td class="name">{{ $item->name }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm view-btn"><i class="bi bi-eye" aria-hidden="true"></i> View</button>
                                            <button class="btn btn-primary btn-sm edit-btn"><i class="bi bi-pencil-square" aria-hidden="true"></i> Edit</button>
                                            <button class="btn btn-danger btn-sm delete-btn"><i class="bi bi-trash" aria-hidden="true"></i> Delete</button>
                                            <button class="btn btn-success btn-sm assign-btn"><i class="bi bi-person-add" aria-hidden="true"></i> Modify Members</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
