<script type="text/javascript">
    @if (Session::get('success'))
        toastr.success('{{ Session::get('success') }}', 'Successful');
    @endif
    @if (Session::get('error'))
        toastr.error('{{ Session::get('error') }}', 'Error');
    @endif
    @if (count($errors) > 0)
        // console.log('{!! implode('<br>', $errors->all()) !!}');
        toastr.error('{!! implode('<br>', $errors->all()) !!}', 'Error');
    @endif

    function copyFunction(element) {
        var aux = document.createElement("input");
        // Assign it the value of the specified element
        aux.setAttribute("value", element);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);

        toastr.info('Copied Successfully', "Success");
    }

    window.addEventListener('alert', event => {
        event.detail.forEach(({ type, message, title }) => {
            toastr[type](message, title ?? 'Successful');
        });
    });

    $(document).ready(function() {
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();

            // Get the custom message from the data-message attribute
            var message = $(this).data('message') || "Do you really want to delete this?";

            // Show a confirmation popup with the custom message
            Swal.fire({
                title: "Are you sure?",
                text: message,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $(this).attr('href');
                } else {
                    Swal.fire(
                        'Cancelled',
                        'You canceled the operation!',
                        'info'
                    );
                }
            });
        });
        // Approve Contest
        $('.approve-btn').on('click', function() {
            const url = $(this).data('url');
            const msg = $(this).data('message') || "You want to approve this?";
            Swal.fire({
                title: 'Are you sure?',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

        // Reject Contest
        $('.reject-btn').on('click', function() {
            const url = $(this).data('url');
            const msg = $(this).data('message') || "You want to reject this ?";
            Swal.fire({
                title: 'Are you sure?',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

    });

    (function($) {
        "use strict";
        $(document).on('click', '.confirmBtn', function() {
            var modal = $('#confirmationModal');
            let data = $(this).data();
            modal.find('.question').text(`${data.question}`);
            modal.find('form').attr('action', `${data.action}`);
            modal.modal('show');
        });
    })(jQuery);

    function openLink(url, target = '_self') {
        window.open(url, target);
    }

    function updateSystem(el, name) {
        if ($(el).is(':checked')) {
            var value = 1;
        } else {
            var value = 0;
        }
        $.post('{{ route('admin.settings.sys_settings') }}', {
            _token: '{{ csrf_token() }}',
            name: name,
            value: value
        }, function(data) {
            if (data == '1') {
                toastr.success('Settings updated successfully', 'Success')
            } else {
                toastr.error('Something went wrong', 'Error')
            }
        });
    }
</script>
