/**
 * Our Brands module scripts (list page + add/edit pages).
 * Needs: jQuery. List page also needs DataTables.
 */

$(document).ready(function () {

    // ---------------------------------------------------------------
    // 1. DataTable (only on the list page, where #brands_table exists)
    // ---------------------------------------------------------------
    if ($('#brands_table').length && typeof window.APP_URLS !== 'undefined') {

        var brandsTable = $('#brands_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: window.APP_URLS.getOurBrandsData,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'icon', name: 'icon', orderable: false, searchable: false },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Toggle status (switch on the list page)
        $('#brands_table').on('change', '.toggle-status', function () {
            var $switch = $(this);
            var id = $switch.data('id');

            $.ajax({
                url: window.APP_URLS.toggleOurBrandStatus.replace(':id', id),
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

        // Delete brand
        $('#brands_table').on('click', '.btn-delete-brand', function () {
            var id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this brand?')) {
                return;
            }

            $.ajax({
                url: window.APP_URLS.deleteOurBrands.replace(':id', id),
                type: 'DELETE',
                data: { _token: window.APP_URLS.csrfToken },
                success: function (response) {
                    showMessage(response.message || 'Brand deleted successfully.', 'success');
                    brandsTable.ajax.reload(null, false);
                },
                error: function () {
                    showMessage('Something went wrong while deleting the brand.', 'danger');
                }
            });
        });
    }

    // ---------------------------------------------------------------
    // 2. Image preview (add / edit pages)
    // ---------------------------------------------------------------
    $(document).on('change', '#brand_icon', function () {
        var input = this;
        var $preview = $('#preview_brand_icon');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $preview.attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    });

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
