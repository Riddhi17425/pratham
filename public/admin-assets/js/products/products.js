/**
 * Products module scripts (list page + add/edit pages).
 * Needs: jQuery. List page also needs DataTables.
 * Add/Edit pages need jQuery Validate + Summernote.
 */

$(document).ready(function () {

    // ---------------------------------------------------------------
    // 1. DataTable (only on the list page, where #products_table exists)
    // ---------------------------------------------------------------
    if ($('#products_table').length && typeof window.APP_URLS !== 'undefined') {

        var productsTable = $('#products_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: window.APP_URLS.getProductsData,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'image', name: 'image', orderable: false, searchable: false },
                { data: 'category', name: 'category', orderable: false, searchable: false },
                { data: 'title', name: 'title' },
                { data: 'name', name: 'name' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Toggle status (switch on the list page)
        $('#products_table').on('change', '.toggle-status', function () {
            var $switch = $(this);
            var id = $switch.data('id');

            $.ajax({
                url: window.APP_URLS.toggleProductStatus.replace(':id', id),
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

        // Delete product
        $('#products_table').on('click', '.btn-delete-product', function () {
            var id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this product?')) {
                return;
            }

            $.ajax({
                url: window.APP_URLS.deleteProducts.replace(':id', id),
                type: 'DELETE',
                data: { _token: window.APP_URLS.csrfToken },
                success: function (response) {
                    showMessage(response.message || 'Product deleted successfully.', 'success');
                    productsTable.ajax.reload(null, false);
                },
                error: function () {
                    showMessage('Something went wrong while deleting the product.', 'danger');
                }
            });
        });
    }

    // ---------------------------------------------------------------
// 2. Summernote editors (add / edit pages)
// ---------------------------------------------------------------
function initEditor(selector, height, placeholder) {
    var $el = $(selector);

    if (!$el.length || !$.fn.summernote) {
        return;
    }

    $el.summernote({
        height: height,
        placeholder: placeholder,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['codeview']]
        ],
        callbacks: {
            // keep the hidden textarea in sync (empty editor => empty value,
            // so the "required" rule works and "<p><br></p>" is not saved)
            onChange: function (contents) {
                $el.val($el.summernote('isEmpty') ? '' : contents);

                if ($el.closest('form').data('validator')) {
                    $el.valid();
                }
            }
        }
    });
}

initEditor('#product_description', 200, 'Enter Description');
initEditor('#product_technical_details', 300, 'Enter Technical Details');
    // ---------------------------------------------------------------
    // 3. Image preview (add / edit pages)
    // ---------------------------------------------------------------
    $(document).on('change', '#product_image', function () {
        var input = this;
        var $preview = $('#preview_product_image');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $preview.attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
   
            // ---------------------------------------------------------------
    // 4. Auto-generate Product URL from Product Name (add / edit pages)
    //    - Name likhte hi URL auto bharega
    //    - User URL khud change kare to auto-fill band ho jayega
    //    - URL khali kar do to auto-fill wapas shuru
    // ---------------------------------------------------------------
    function slugify(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/&/g, ' and ')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    var $nameInput = $('input[name="name"]');
    var $urlInput  = $('input[name="product_url"]');

    if ($nameInput.length && $urlInput.length) {
        // Edit page par agar saved URL custom hai (name se alag), to usko overwrite mat karo
        var urlEdited = $.trim($urlInput.val()) !== '' &&
                        $urlInput.val() !== slugify($nameInput.val());

        $nameInput.on('input', function () {
            if (!urlEdited) {
                $urlInput.val(slugify($(this).val()));
                if ($urlInput.closest('form').data('validator')) {
                    $urlInput.valid();
                }
            }
        });

        $urlInput.on('input', function () {
            // user ne khud type kiya => auto band; khali kiya => auto wapas chalu
            urlEdited = $.trim($(this).val()) !== '';
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
