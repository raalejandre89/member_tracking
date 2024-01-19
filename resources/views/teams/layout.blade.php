<!DOCTYPE html>
<html>
<head>
    <title>Team Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha256-MBffSnbbXwHCuZtgPYiwMQbfE7z+GOZ7fBPCNB06Z98=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src=" https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js "></script>
</head>
<body>

<div class="container">
    @yield('content')
</div>
<script>
    (() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})();

    $(document).ready(function() {
        $('#storeTeam').submit(function(e) {
            e.preventDefault();

            var nameInput = document.getElementById('name');
            var nameFeedback = document.getElementById('name-feedback');
            var id = $('#id').val();

            var sendAjax = true;

            if (nameInput.value) {
                // Clear error message and remove 'is-invalid' class
                nameFeedback.style.display = 'none';
                nameInput.classList.remove('is-invalid');
            } else {
                nameFeedback.style.display = 'block';
                nameInput.classList.add('is-invalid');
                sendAjax = false
            }

            if (sendAjax) {
                var method = id ? 'PUT' : 'POST';
                var url = id ? '/team/' + id : '/team';

                $.ajax({
                    type: method,
                    url: window.location.origin + url,
                    data: $(this).serialize(),
                    success: function(data) {
                        // Handle success (e.g., close modal, show success message)
                        $('#createTeam').modal('hide');
                        location.reload();
                    },
                    error: function(data) {
                        $('.form-input').each(function() {
                            $(this).removeClass('is-invalid');
                        });
                        $('.invalid-feedback').hide();
                        // Handle validation errors
                        if (data.status === 422) { // Validation Failed
                            let errors = data.responseJSON.errors;
                            $.each(errors, function(key, error) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '-feedback').text(error[0]).show();
                            });
                            $('#storeTeam').removeClass('was-validated');
                        }
                    }
                });
            }
        });

        $('#createTeam').on('hide.bs.modal', function () {
            $('#storeTeam')[0].reset();
            $('#storeTeam').removeClass('was-validated');

            $('.form-input').each(function() {
                $(this).removeClass('is-invalid');
            });

            $('.invalid-feedback').each(function() {
                $(this).removeAttr('style');
            });

            $('#id').val('');
            $('#createModalLabel').text('Add Team');
        });

        $('.view-btn').click(function(e) {
            // Find the parent row and get the ID value
            var id = $(this).closest('tr').find('.id').text();

            // Do something with the ID
            console.log('ID:', id);
            $.ajax({
                type: 'GET',
                url: window.location.origin + '/team/' + id,
                success: function(data) {
                    //console.log('DATA', data);
                    // Handle success (e.g., close modal, show success message)
                    $('#teamName').text(data.name);
                    $('#viewTeam').modal('show');
                }
            });
        });

        $('.edit-btn').click(function(e) {
            // Find the parent row and get the ID value
            $tr = $(this).closest('tr');
            var id = $tr.find('.id').text();
            var name = $tr.find('.name').text();

            $('#name').val(name);
            $('#id').val(id);

            $('#createModalLabel').text('Update Team');

            $('#createTeam').modal('show');
        });

        // Variable to store the ID of the item to delete
        var itemIdToDelete;

        // Listen for click event on delete button (replace with your own selector)
        $('.delete-btn').click(function() {
            $tr = $(this).closest('tr');
            itemIdToDelete = $tr.find('.id').text();
            $('#deleteAlert').hide();
            $('#deleteConfirmationModal').modal('show'); // Show the modal
        });

        $('#deleteConfirmationModal').on('hide.bs.modal', function () {
            $('#deleteAlert').hide();
        });

        // Handle the confirmation button click
        $('#confirmDelete').click(function() {
            $.ajax({
                url: window.location.origin + '/team/' + itemIdToDelete,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(result) {
                    // Handle success (e.g., close the modal and update the UI)
                    $('#deleteConfirmationModal').modal('hide');
                    location.reload();
                },
                error: function(error) {
                    if (error.status === 403) { // Validation Failed
                        $('#deleteAlert').show();
                    }
                }
            });
        });

        $('.see-btn').click(function() {
            $tr = $(this).closest('tr');
            var id = $tr.find('.id').text();
            $.ajax({
                url: window.location.origin + '/api/team/' + id + '/members', // Replace with your API endpoint
                type: 'GET',
                success: function(response) {
                    var memberList = $('#memberList');
                    memberList.empty(); // Clear existing list items

                    // Assuming 'response' is an array of member objects
                    $.each(response, function(index, member) {
                        memberList.append('<li class="list-group-item">' + member.first_name + ' ' + member.last_name + '</li>');
                    });

                    // Show the modal after list is populated
                    $('#membersModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.log(error);
                }
            });
        });
    });
</script>
</body>
</html>
