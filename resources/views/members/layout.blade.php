<!DOCTYPE html>
<html>
<head>
    <title>Member Management</title>
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
        $('#storeMember').submit(function(e) {
            e.preventDefault();

            var firstNameInput = document.getElementById('first_name');
            var firstNameFeedback = document.getElementById('first_name-feedback');
            var lastNameInput = document.getElementById('last_name');
            var lastNameFeedback = document.getElementById('last_name-feedback');
            var teamSelect = document.getElementById('team_id');
            var teamSelectFeedback = document.getElementById('team_select-feedback');
            // Regex pattern for validating names
            var namePattern = /^[^\d]+$/;
            var sendAjax = true;
            var id = $('#id').val();

            if (firstNameInput.value) {
                if (!namePattern.test(firstNameInput.value)) {
                    // Show error message and add Bootstrap 'is-invalid' class
                    firstNameFeedback.style.display = 'block';
                    firstNameFeedback.textContent = 'First name can\'t contain numbers. Please enter a valid first name.';
                    firstNameInput.classList.add('is-invalid');
                    $('#storeMember').removeClass('was-validated');
                    sendAjax = false;
                } else {
                    // Clear error message and remove 'is-invalid' class
                    firstNameFeedback.style.display = 'none';
                    firstNameInput.classList.remove('is-invalid');
                }
            } else {
                firstNameFeedback.style.display = 'block';
                firstNameInput.classList.add('is-invalid');
                sendAjax = false
            }

            if (lastNameInput.value) {
                if (!namePattern.test(lastNameInput.value)) {
                    // Show error message and add Bootstrap 'is-invalid' class
                    lastNameFeedback.style.display = 'block';
                    lastNameFeedback.textContent = 'Last name can\'t contain numbers. Please enter a valid last name.';
                    lastNameInput.classList.add('is-invalid');

                    $('#storeMember').removeClass('was-validated');
                    sendAjax = false;
                } else {
                    // Clear error message and remove 'is-invalid' class
                    lastNameFeedback.style.display = 'none';
                    lastNameInput.classList.remove('is-invalid');
                }
            } else {
                lastNameFeedback.style.display = 'block';
                lastNameInput.classList.add('is-invalid');
                sendAjax = false
            }

            if (teamSelect.value === '0') {
                // Show error message and add Bootstrap 'is-invalid' class
                teamSelectFeedback.style.display = 'block';
                teamSelect.classList.add('is-invalid');
                $('#storeMember').removeClass('was-validated');
                sendAjax = false;
            } else {
                // Clear error message and remove 'is-invalid' class
                teamSelectFeedback.style.display = 'none';
                teamSelect.classList.remove('is-invalid');
            }

            if (sendAjax) {
                var method = id ? 'PUT' : 'POST';
                var url = id ? '/member/' + id : '/member';

                $.ajax({
                    type: method,
                    url: window.location.origin + url,
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(data) {
                        // Handle success (e.g., close modal, show success message)
                        $('#createMember').modal('hide');
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
                            $('#storeMember').removeClass('was-validated');
                        }
                    }
                });
            }
        });

        $('#createMember').on('hide.bs.modal', function () {
            $('#storeMember')[0].reset();
            $('#storeMember').removeClass('was-validated');

            $('.form-input').each(function() {
                $(this).removeClass('is-invalid');
            });

            $('.invalid-feedback').each(function() {
                $(this).removeAttr('style');
            });

            $('#id').val('');
            $('#createModalLabel').text('Add Member');
        });

        $('.view-btn').click(function(e) {
            // Find the parent row and get the ID value
            var id = $(this).closest('tr').find('.id').text();

            $.ajax({
                type: 'GET',
                url: window.location.origin + '/member/' + id,
                success: function(data) {
                    // Handle success (e.g., close modal, show success message)
                    $('#firstName').text(data.first_name);
                    $('#lastName').text(data.last_name);
                    $('#cityView').text(data.city);
                    $('#stateView').text(data.state);
                    $('#countryView').text(data.country);
                    $('#team').text(data.team.name);

                    $('#viewMember').modal('show');
                }
            });
        });

        $('.edit-btn').click(function(e) {
            // Find the parent row and get the ID value
            $tr = $(this).closest('tr');
            var id = $tr.find('.id').text();
            var fName = $tr.find('.fName').text();
            var lName = $tr.find('.lName').text();
            var city = $tr.find('.city').text();
            var state = $tr.find('.state').text();
            var country = $tr.find('.country').text();
            var tName = $tr.find('.tName').text();

            $('#first_name').val(fName);
            $('#last_name').val(lName);
            $('#city').val(city);
            $('#state').val(state);
            $('#country').val(country);
            $('#id').val(id);

            $("#team_id option").each(function() {
                if ($(this).text() === tName) {
                    $(this).prop('selected', true);

                    return false;
                }
            });

            $('#createModalLabel').text('Update Member');

            $('#createMember').modal('show');
        });

        // Variable to store the ID of the item to delete
        var itemIdToDelete;

        // Listen for click event on delete button (replace with your own selector)
        $('.delete-btn').click(function() {
            $tr = $(this).closest('tr');
            itemIdToDelete = $tr.find('.id').text();

            $('#deleteConfirmationModal').modal('show'); // Show the modal
        });

        // Handle the confirmation button click
        $('#confirmDelete').click(function() {
            $.ajax({
                url: window.location.origin + '/member/' + itemIdToDelete,
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

        var memberIdToChange;

        $('.assign-btn').click(function() {
            $tr = $(this).closest('tr');
            memberIdToChange = $tr.find('.id').text();
            var currentTeam = $tr.find('.tName').text();

            $("#new_team_id option").filter(function() {
                return $(this).text() === currentTeam;
            }).remove();

            $('#swapTeamModal').modal('show');
        });

        $('#saveChangeTeam').click(function() {
            $.ajax({
                url: window.location.origin + '/api/member/change-team', // Replace with your API endpoint
                type: 'POST',
                data: {
                    'id':memberIdToChange,
                    'team_id':$('#new_team_id').val(),
                },
                success: function(response) {
                    $('#swapTeamModal').modal('hide');
                    location.reload();
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
