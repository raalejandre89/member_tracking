<!DOCTYPE html>
<html>
<head>
    <title>Project Management</title>
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
        $('#storeProject').submit(function(e) {
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
                var url = id ? '/project/' + id : '/project';

                $.ajax({
                    type: method,
                    url: window.location.origin + url,
                    data: $(this).serialize(),
                    success: function(data) {
                        // Handle success (e.g., close modal, show success message)
                        $('#createProject').modal('hide');
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
                            $('#storeProject').removeClass('was-validated');
                        }
                    }
                });
            }
        });

        $('#createProject').on('hide.bs.modal', function () {
            $('#storeProject')[0].reset();
            $('#storeProject').removeClass('was-validated');

            $('.form-input').each(function() {
                $(this).removeClass('is-invalid');
            });

            $('.invalid-feedback').each(function() {
                $(this).removeAttr('style');
            });

            $('#id').val('');
            $('#createModalLabel').text('Add Project');
        });

        $('.view-btn').click(function(e) {
            // Find the parent row and get the ID value
            var id = $(this).closest('tr').find('.id').text();

            // Do something with the ID
            console.log('ID:', id);
            $.ajax({
                type: 'GET',
                url: window.location.origin + '/project/' + id,
                success: function(data) {
                    //console.log('DATA', data);
                    // Handle success (e.g., close modal, show success message)
                    $('#projectName').text(data.name);
                    $('#viewProject').modal('show');
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

            $('#createModalLabel').text('Update Project');

            $('#createProject').modal('show');
        });

        // Variable to store the ID of the item to delete
        var itemId;

        // Listen for click event on delete button (replace with your own selector)
        $('.delete-btn').click(function() {
            $tr = $(this).closest('tr');
            itemId = $tr.find('.id').text();

            $('#deleteConfirmationModal').modal('show'); // Show the modal
        });

        // Handle the confirmation button click
        $('#confirmDelete').click(function() {
            $.ajax({
                url: window.location.origin + '/project/' + itemId,
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
                    // Handle error
                }
            });

            $('#deleteConfirmationModal').modal('hide'); // Close the modal
        });

        // Listen for click event on delete button (replace with your own selector)
        $('.assign-btn').click(function() {
            $tr = $(this).closest('tr');
            itemId = $tr.find('.id').text();

            $.ajax({
                type: 'GET',
                url: window.location.origin + '/api/project/' + itemId + '/members',
                success: function(data) {
                    //console.log('DATA', data);
                    // Handle success (e.g., close modal, show success message)
                    $.each(data, function(index, member) {
                        var newCheckbox = '<li class="list-group-item">' +
                            '<input type="checkbox" id="checkbox' + member.id + '" checked value="' + member.id + '" class="modal-checkbox">\n' +
                            '<label for="checkbox' + member.id + '"> ' + member.first_name + ' ' + member.last_name + '</label>' +
                            '</li>';

                        $('#membersCheckboxList').append(newCheckbox);
                    });
                    $('#availableMembersModal').modal('show');
                }
            });
        });

        $('#availableMembersModal').on('hide.bs.modal', function () {
            $(this).find('.modal-checkbox').prop('checked', false);
            location.reload();
        });

        // Handle the confirmation button click
        $('#assignMembers').click(function() {
            var members_ids = $('#membersCheckboxList input:checked').map(function() {
                return this.value;
            }).get();

            $.ajax({
                url: window.location.origin + '/api/project/change-members',
                type: 'POST',
                data: {
                    'id':itemId,
                    'members_ids':members_ids,
                },
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(result) {
                    // Handle success (e.g., close the modal and update the UI)
                    $('#availableMembersModal').modal('hide');
                    location.reload();
                },
                error: function(error) {
                    // Handle error
                }
            });

            $('#availableMembersModal').modal('hide'); // Close the modal
        });
    });
</script>
</body>
</html>
