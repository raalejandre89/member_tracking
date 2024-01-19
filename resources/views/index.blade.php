<!DOCTYPE html>
<html>
<head>
    <title>Member Tracking Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha256-MBffSnbbXwHCuZtgPYiwMQbfE7z+GOZ7fBPCNB06Z98=" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src=" https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js "></script>
</head>
<body>

<div class="container">
    <div class="row" style="margin:20px;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Member Tracking Application</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{url('/team')}}" title="Manage Teams"><button class="btn btn-primary">Manage Teams</button></a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{url('/member')}}" title="Manage Members"><button class="btn btn-primary">Manage Members</button></a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{url('/project')}}" title="Manage Projects"><button class="btn btn-primary">Manage Projects</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
