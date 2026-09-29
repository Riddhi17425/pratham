/**
 * Settings module scripts (list page + add/edit pages).
 * Needs: jQuery. List page also needs DataTables. Add/Edit pages need jQuery Validate.
 */

$(document).ready(function () {

    // ---------------------------------------------------------------
    // 1. DataTable (only on the list page, where #settings_table exists)
    // ---------------------------------------------------------------
    if ($('#settings_table').length && typeof window.APP_URLS !== 'undefined') {

        var settingsTable = $('#settings_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: window.APP_URLS.getSettingsData,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'address', name: 'address' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Delete setting
        $('#settings_table').on('click', '.btn-delete-setting', function () {
            var id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this setting?')) {
                return;
            }

            $.ajax({
                url: window.APP_URLS.deleteSettings.replace(':id', id),
                type: 'DELETE',
                data: { _token: window.APP_URLS.csrfToken },
                success: function (response) {
                    showMessage(response.message || 'Setting deleted successfully.', 'success');
                    settingsTable.ajax.reload(null, false);
                },
                error: function () {
                    showMessage('Something went wrong while deleting the setting.', 'danger');
                }
            });
        });
    }

    // ---------------------------------------------------------------
    // 2. Custom validation rule: phone number (add / edit pages)
    // ---------------------------------------------------------------
    if ($.validator) {
        $.validator.addMethod('phoneNumber', function (value, element) {
            return this.optional(element) || /^[0-9+\-()\s]{7,20}$/.test(value);
        }, 'Please enter a valid phone number.');
    }

    // ---------------------------------------------------------------
    // Helper: show a dismissible message in the #message-pop-up alert
    // ---------------------------------------------------------------
    function showMessage(message, type) {
        var $popup = $('#message-pop-up');

        if (!$popup.length) {
            return;
        }

        $popup
            .removeClass('alert-success alert-danger')
            .addClass('alert-' + (type || 'success'))
            .show();

        $('#success-message').text(message);

        setTimeout(function () {
            $popup.fadeOut();
        }, 4000);
    }
});
