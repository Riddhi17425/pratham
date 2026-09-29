/**
 * Banners module scripts (list page + add/edit pages).
 * Needs: jQuery. List page also needs DataTables. Add/Edit pages need Summernote.
 */

$(document).ready(function () {

    // ---------------------------------------------------------------
    // 1. DataTable (only on the list page, where #banners_table exists)
    // ---------------------------------------------------------------
    if ($('#banners_table').length && typeof window.APP_URLS !== 'undefined') {

        var bannersTable = $('#banners_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: window.APP_URLS.getBannersData,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'title', name: 'title' },
                { data: 'description', name: 'description', orderable: false },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Delete banner
        $('#banners_table').on('click', '.btn-delete-banner', function () {
            var id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this banner?')) {
                return;
            }

            $.ajax({
                url: window.APP_URLS.deleteBanners.replace(':id', id),
                type: 'DELETE',
                data: { _token: window.APP_URLS.csrfToken },
                success: function (response) {
                    showMessage(response.message || 'Banner deleted successfully.', 'success');
                    bannersTable.ajax.reload(null, false);
                },
                error: function () {
                    showMessage('Something went wrong while deleting the banner.', 'danger');
                }
            });
        });
    }

    // ---------------------------------------------------------------
    // 2. Summernote editor (add / edit pages)
    // ---------------------------------------------------------------
    if ($('#banner_description').length && $.fn.summernote) {
        $('#banner_description').summernote({
            height: 250,
            placeholder: 'Enter Description',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ],
            callbacks: {
                // keep the hidden textarea in sync so jQuery Validate can read it
                onChange: function (contents) {
                    var $el = $('#banner_description');
                    $el.val(contents);
                    if ($el.closest('form').data('validator')) {
                        $el.valid();
                    }
                }
            }
        });
    }

    // ---------------------------------------------------------------
    // 3. Image preview (add / edit pages)
    // ---------------------------------------------------------------
    $(document).on('change', '#banner_image', function () {
        var input = this;
        var $preview = $('#preview_banner_image');

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
