/**
 * Categories module scripts (list page + add/edit pages).
 * Needs: jQuery. List page also needs DataTables.
 * Add/Edit pages need jQuery Validate + Summernote.
 */

$(document).ready(function () {

    // ---------------------------------------------------------------
    // 1. DataTable (only on the list page, where #categories_table exists)
    // ---------------------------------------------------------------
    if ($('#categories_table').length && typeof window.APP_URLS !== 'undefined') {

        var categoriesTable = $('#categories_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: window.APP_URLS.getCategoriesData,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false },
                { data: 'title', name: 'title' },
                { data: 'category_url', name: 'category_url' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Toggle status (switch on the list page)
        $('#categories_table').on('change', '.toggle-status', function () {
            var $switch = $(this);
            var id = $switch.data('id');

            $.ajax({
                url: window.APP_URLS.toggleCategoryStatus.replace(':id', id),
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

        // Delete category
        $('#categories_table').on('click', '.btn-delete-category', function () {
            var id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this category?')) {
                return;
            }

            $.ajax({
                url: window.APP_URLS.deleteCategories.replace(':id', id),
                type: 'DELETE',
                data: { _token: window.APP_URLS.csrfToken },
                success: function (response) {
                    showMessage(response.message || 'Category deleted successfully.', 'success');
                    categoriesTable.ajax.reload(null, false);
                },
                error: function () {
                    showMessage('Something went wrong while deleting the category.', 'danger');
                }
            });
        });
    }

    // ---------------------------------------------------------------
    // 2. Summernote editor for description (add / edit pages)
    // ---------------------------------------------------------------
    if ($('#category_description').length && $.fn.summernote) {
        $('#category_description').summernote({
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
                // keep the hidden textarea in sync
                onChange: function (contents) {
                    $('#category_description').val(contents);
                }
            }
        });
    }

    // ---------------------------------------------------------------
    // 3. Thumbnail preview (add / edit pages)
    // ---------------------------------------------------------------
    $(document).on('change', '#category_thumbnail', function () {
        var input = this;
        var $preview = $('#preview_category_thumbnail');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $preview.attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    });

    // ---------------------------------------------------------------
    // 4. Category URL: custom rule + auto-fill from title (add page only)
    // ---------------------------------------------------------------
    
    if ($('#categoryForm[data-auto-slug]').length) {
        var slugEdited = $('#category_url').val() !== '';

        $('#category_url').on('input', function () {
            slugEdited = true;
        });

        $('#category_title').on('input', function () {
            if (slugEdited) {
                return;
            }
            var slug = $(this).val()
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            $('#category_url').val(slug);
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
