/**
 * Locators module scripts (list page + add/edit pages).
 * Needs: jQuery. List page also needs DataTables. Add/Edit pages need jQuery Validate.
 */

$(document).ready(function () {

    // ---------------------------------------------------------------
    // 1. DataTable (only on the list page, where #locators_table exists)
    // ---------------------------------------------------------------
    if ($('#locators_table').length && typeof window.APP_URLS !== 'undefined') {

        var locatorsTable = $('#locators_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: window.APP_URLS.getLocatorsData,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'city', name: 'city' },
                { data: 'address', name: 'address' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Toggle status (switch on the list page)
        $('#locators_table').on('change', '.toggle-status', function () {
            var $switch = $(this);
            var id = $switch.data('id');

            $.ajax({
                url: window.APP_URLS.toggleLocatorStatus.replace(':id', id),
                type: 'POST',
                data: { _token: window.APP_URLS.csrfToken },
                success: function (response) {
                    showMessage(response.message || 'Status updated successfully.', 'success');
                },
                error: function () {
                    // request failed: put the switch back to its old state
                    $switch.prop('checked', !$switch.prop('checked'));
                    showMessage('Something went wrong while updating the status.', 'danger');
                }
            });
        });

        // Delete locator
        $('#locators_table').on('click', '.btn-delete-locator', function () {
            var id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this locator?')) {
                return;
            }

            $.ajax({
                url: window.APP_URLS.deleteLocators.replace(':id', id),
                type: 'DELETE',
                data: { _token: window.APP_URLS.csrfToken },
                success: function (response) {
                    showMessage(response.message || 'Locator deleted successfully.', 'success');
                    locatorsTable.ajax.reload(null, false);
                },
                error: function () {
                    showMessage('Something went wrong while deleting the locator.', 'danger');
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
