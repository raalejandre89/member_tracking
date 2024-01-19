@extends('teams.layout')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Teams CRUD (Create, Read, Update and Delete)</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{url('/')}}" title="Home"><button class="btn btn-secondary"><i class="bi bi-house-door" aria-hidden="true"></i> Home</button></a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTeam"><i class="bi bi-plus-lg" aria-hidden="true"></i>
                                Add Team
                            </button>
                        </div>
                        <!-- Create Modal -->
                        <div class="modal fade" id="createTeam" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="createModalLabel">Add Team</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="storeTeam" class="needs-validation" novalidate>
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
                        <div class="modal fade" id="viewTeam" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="teamModalLabel">Team Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Team Name -->
                                        <p><strong>Name:</strong> <span id="teamName">[Team Name Here]</span></p>
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
                                    <div id="deleteAlert" class="alert alert-danger" role="alert">
                                        This team has members in it. Please assign members to a different team or delete the members.
                                    </div>

                                    <div class="modal-body">
                                        Are you sure you want to delete this team?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Delete Modal -->
                        <!-- End Delete Modal -->
                        <div class="modal fade" id="membersModal" tabindex="-1" aria-labelledby="membersModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="membersModalLabel">Members List</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul id="memberList" class="list-group">
                                            <!-- Member list items will be inserted here -->
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                                @foreach($teams as $item)
                                    <tr>
                                        <td class="id">{{ $item->id }}</td>
                                        <td class="name">{{ $item->name }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm view-btn"><i class="bi bi-eye" aria-hidden="true"></i> View</button>
                                            <button class="btn btn-primary btn-sm edit-btn"><i class="bi bi-pencil-square" aria-hidden="true"></i> Edit</button>
                                            <button class="btn btn-danger btn-sm delete-btn"><i class="bi bi-trash" aria-hidden="true"></i> Delete</button>
                                            <button class="btn btn-success btn-sm see-btn"><i class="bi bi-people-fill" aria-hidden="true"></i> Members</button>
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
