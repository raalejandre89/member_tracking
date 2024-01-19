@extends('members.layout')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Member CRUD (Create, Read, Update and Delete)</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{url('/')}}" title="Home"><button class="btn btn-secondary"><i class="bi bi-house-door" aria-hidden="true"></i> Home</button></a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMember"><i class="bi bi-plus-lg" aria-hidden="true"></i>
                                Add Member
                            </button>
                        </div>
                        <!-- Create Modal -->
                        <div class="modal fade" id="createMember" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="createModalLabel">Add Member</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="storeMember" class="needs-validation" novalidate>
                                        <div class="modal-body">
                                        {!! csrf_field() !!}
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="first_name" class="form-label">First Name</label>
                                                    <input type="text" class="form-control form-input" id="first_name" name="first_name" required>
                                                    <div class="invalid-feedback" id="first_name-feedback">
                                                        Please provide a first name.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="last_name" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control form-input" id="last_name" name="last_name" required>
                                                    <div class="invalid-feedback" id="last_name-feedback">
                                                        Please provide a last name.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label for="city" class="form-label">City</label>
                                                    <input type="text" class="form-control" id="city" name="city">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="inputField4" class="form-label">State</label>
                                                    <input type="text" class="form-control" id="state" name="state">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="inputField5" class="form-label">Country</label>
                                                    <input type="text" class="form-control" id="country" name="country">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <select id="team_id" class="form-select" aria-label="team select" name="team_id" required>
                                                    <option selected value="0">Select a Team</option>
                                                    @foreach($teams as $team)
                                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback" id="team_select-feedback">
                                                    Please select a name.
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
                        <!-- View Modal -->
                        <div class="modal fade" id="viewMember" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="memberModalLabel">Member Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <p><strong>First Name:</strong> <span id="firstName">[Member First Name Here]</span></p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <p><strong>Last Name:</strong> <span id="lastName">[Member Last Name Here]</span></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <p><strong>City:</strong> <span id="cityView">[Member City Here]</span></p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <p><strong>State:</strong> <span id="stateView">[Member State Here]</span></p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <p><strong>Country:</strong> <span id="countryView">[Member Country Here]</span></p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <p><strong>Team:</strong> <span id="team">[Member Team Here]</span></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End View Modal -->
                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this member?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Delete Modal -->
                        <div class="modal fade" id="swapTeamModal" tabindex="-1" aria-labelledby="swapTeamModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="swapTeamModalLabel">Teams List</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <select id="new_team_id" class="form-select" aria-label="team select" name="new_team_id" required>
                                            <option selected value="0">Select a New Team</option>
                                            @foreach($teams as $team)
                                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="saveChangeTeam">Save</button>
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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Team</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($members as $item)
                                    <tr>
                                        <td class="id">{{ $item->id }}</td>
                                        <td class="fName">{{ $item->first_name }}</td>
                                        <td class="lName">{{ $item->last_name }}</td>
                                        <td class="city">{{ $item->city }}</td>
                                        <td class="state">{{ $item->state }}</td>
                                        <td class="country">{{ $item->country }}</td>
                                        <td class="tName">{{ $item->team->name }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm view-btn"><i class="bi bi-eye" aria-hidden="true"></i> View</button>
                                            <button class="btn btn-primary btn-sm edit-btn"><i class="bi bi-pencil-square" aria-hidden="true"></i> Edit</button>
                                            <button class="btn btn-danger btn-sm delete-btn"><i class="bi bi-trash" aria-hidden="true"></i> Delete</button>
                                            <button class="btn btn-success btn-sm assign-btn"><i class="bi bi-repeat" aria-hidden="true"></i> Change Team</button>
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
