/**
 * Technical Data Sheets module scripts (list page + add/edit pages).
 * Needs: jQuery. List page also needs DataTables. Add/Edit pages need jQuery Validate.
 */

$(document).ready(function () {

    // ---------------------------------------------------------------
    // 1. DataTable (only on the list page, where #sheets_table exists)
    // ---------------------------------------------------------------
    if ($('#sheets_table').length && typeof window.APP_URLS !== 'undefined') {

        var sheetsTable = $('#sheets_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: window.APP_URLS.getSheetsData,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'category', name: 'category', orderable: false, searchable: false },
                { data: 'brochure', name: 'brochure', orderable: false, searchable: false },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Toggle status (switch on the list page)
        $('#sheets_table').on('change', '.toggle-status', function () {
            var $switch = $(this);
            var id = $switch.data('id');

            $.ajax({
                url: window.APP_URLS.toggleSheetStatus.replace(':id', id),
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

        // Delete data sheet
        $('#sheets_table').on('click', '.btn-delete-sheet', function () {
            var id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this technical data sheet?')) {
                return;
            }

            $.ajax({
                url: window.APP_URLS.deleteSheets.replace(':id', id),
                type: 'DELETE',
                data: { _token: window.APP_URLS.csrfToken },
                success: function (response) {
                    showMessage(response.message || 'Technical data sheet deleted successfully.', 'success');
                    sheetsTable.ajax.reload(null, false);
                },
                error: function () {
                    showMessage('Something went wrong while deleting the technical data sheet.', 'danger');
                }
            });
        });
    }

    // ---------------------------------------------------------------
    // 2. Add/Edit pages: show a cross button to remove the chosen PDF
    // ---------------------------------------------------------------
    var $brochure = $('#sheet_brochure');
    var $clearBtn = $('#clearBrochure');

    if ($brochure.length && $clearBtn.length) {
        $brochure.on('change', function () {
            $clearBtn.toggleClass('d-none', !this.files.length);
        });

        $clearBtn.on('click', function () {
            $brochure.val('');
            $clearBtn.addClass('d-none');
            $brochure.removeClass('is-invalid');

            // Add page: "required" error will show. Edit page: nothing (field is optional).
            var $form = $brochure.closest('form');
            if ($.fn.validate && $form.data('validator')) {
                $form.validate().element($brochure);
            }
        });
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
