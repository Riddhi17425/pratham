$(document).ready(function () {

    // ---------------------------------------------------------------
    // 1. DataTable (only on the list page, where #blogs_table exists)
    // ---------------------------------------------------------------
    if ($('#blogs_table').length && typeof window.APP_URLS !== 'undefined') {

        var blogsTable = $('#blogs_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: window.APP_URLS.getBlogsData,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'title', name: 'title' },
                { data: 'front_image', name: 'front_image', orderable: false, searchable: false },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Delete blog
        $('#blogs_table').on('click', '.btn-delete-blog', function () {
            var id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this blog?')) {
                return;
            }

            $.ajax({
                url: window.APP_URLS.deleteblogs.replace(':id', id),
                type: 'DELETE',
                data: { _token: window.APP_URLS.csrfToken },
                success: function (response) {
                    showMessage(response.message || 'Blog deleted successfully.', 'success');
                    blogsTable.ajax.reload(null, false);
                },
                error: function () {
                    showMessage('Something went wrong while deleting the blog.', 'danger');
                }
            });
        });
    }

    // ---------------------------------------------------------------
    // 2. Image previews (add / edit pages)
    // ---------------------------------------------------------------
    bindImagePreview('#blogs_front_image', '#preview_blogs_front_image');
    bindImagePreview('#blogs_detail_image', '#preview_blogs_detail_image');
    bindImagePreview('#cta_image', '#preview_cta_image');

    function bindImagePreview(inputSelector, previewSelector) {
        $(document).on('change', inputSelector, function () {
            var input = this;
            var $preview = $(previewSelector);

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $preview.attr('src', e.target.result).show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    }

    // ---------------------------------------------------------------
    // 3. Dynamic FAQ rows (add more / remove)
    // ---------------------------------------------------------------
    $(document).on('click', '#addFaq', function () {
        var $wrapper = $('#faq-wrapper');
        var $lastItem = $wrapper.find('.faq-item').first();
        var $newItem = $lastItem.clone();

        // Clear cloned values
        $newItem.find('input[name="faq_title[]"]').val('');
        $newItem.find('input[name="question[]"]').val('');
        $newItem.find('textarea[name="answer[]"]').val('');

        $wrapper.append($newItem);
    });

    $(document).on('click', '.removeFaq', function () {
        var $items = $('#faq-wrapper .faq-item');

        // Keep at least one FAQ row on the form
        if ($items.length > 1) {
            $(this).closest('.faq-item').remove();
        } else {
            $(this).closest('.faq-item').find('input, textarea').val('');
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
