/**
 * Blogs module scripts (list page + add/edit pages).
 * Needs: jQuery. List page also needs DataTables. Add/Edit pages also need Summernote.
 */

// Shared Summernote settings (used by every editor on the blog form, incl. FAQ answers)
window.blogEditorOptions = {
    height: 220,
    toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture']],
        ['view', ['codeview']]
    ],
    callbacks: {
        onChange: function (contents) {
            var $field = $(this);
            $field.val(contents);
            if ($field.hasClass('is-invalid') && $field.closest('form').data('validator')) {
                $field.valid();
            }
        }
    }
};

$(document).ready(function () {

    // ---------------------------------------------------------------
    // 1. DataTable (only on the list page, where #blogs_table exists)
    // ---------------------------------------------------------------
    if ($('#blogs_table').length && typeof window.APP_URLS !== 'undefined') {

        var blogsTable = $('#blogs_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
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
    // 3. Dynamic FAQ rows (question + answer with Summernote editor)
    // ---------------------------------------------------------------
    $(document).on('click', '#addFaq', function () {
        // A fresh row comes from the hidden <template>, so no editor is cloned by mistake
        var $item = $($.trim($('#faq-template').html()));

        $('#faq-wrapper').append($item);

        if ($.fn.summernote) {
            $item.find('.js-editor').summernote(window.blogEditorOptions);
        }
    });

    $(document).on('click', '.removeFaq', function () {
        var $item = $(this).closest('.faq-item');

        // Keep at least one FAQ row on the form: clear it instead of removing it
        if ($('#faq-wrapper .faq-item').length > 1) {
            $item.remove();
        } else {
            $item.find('input').val('');
            $item.find('.js-editor').summernote('code', '');
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
