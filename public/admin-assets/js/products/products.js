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
    // 3b. Catalogue PDF: basket animation + turant upload + cross se remove
    //     (add + edit dono pages)
    // ---------------------------------------------------------------
    var BALL_W = 30, BALL_H = 38;
    var RIM_X = 170, RIM_Y = 112, NET_BOTTOM = 160, SCENE_H = 230;
    var MAX_PDF = 2147483648; // 2 GB

    var $catalogueInput = $('#product_catalogue');
    var $newBox    = $('#catalogue_new_box');
    var $newName   = $('#catalogue_new_name');
    var $temp      = $('#catalogue_temp');
    var $progress  = $('#cb_progress');
    var $bar       = $('#cb_progress_bar');
    var $submitBtn = $('#productForm button[type="submit"]');
    var currentXhr = null;

    if ($('#cb_stage').length) {
        $('<style>').text(
            '.cb-stage{position:relative;width:340px;max-width:100%;height:230px;margin-top:10px;overflow:hidden;border-radius:12px;' +
            'border:1px solid #dee2e6;background:#f8f9fa}' +
            '.cb-bg,.cb-front{position:absolute;left:0;top:0;width:340px;height:230px;pointer-events:none}' +
            '.cb-bg{z-index:0}.cb-front{z-index:2}' +
            '.cb-ball{position:absolute;left:0;top:0;width:30px;height:38px;display:none;align-items:flex-end;justify-content:center;padding-bottom:6px;' +
            'font:700 10px/1 sans-serif;color:#fff;background:linear-gradient(160deg,#ff6b6b,#c92a2a);border-radius:3px;' +
            'clip-path:polygon(0 0,calc(100% - 9px) 0,100% 9px,100% 100%,0 100%);z-index:1;transform:translate(8px,178px)}' +
            '.cb-ball::after{content:"";position:absolute;top:0;right:0;width:9px;height:9px;background:linear-gradient(to top right,#ffc9c9 50%,transparent 50%)}' +
            '.cb-net line{stroke:#868e96;stroke-width:1.4}' +
            '.cb-net{transform-origin:170px 112px}' +
            '.cb-net.swish{animation:cbSwish .6s ease}' +
            '@keyframes cbSwish{0%{transform:scale(1,1)}30%{transform:scale(1.12,.92)}60%{transform:scale(.94,1.06)}100%{transform:scale(1,1)}}' +
            '.cb-hint:empty{display:none}' +
            '.cb-hint{position:absolute;right:8px;bottom:8px;max-width:170px;padding:5px 10px;border-radius:14px;z-index:3;' +
            'font:600 12px/1.3 sans-serif;color:#495057;background:rgba(255,255,255,.9);border:1px dashed #adb5bd;transition:all .3s}' +
            '.cb-hint.done{color:#2b8a3e;background:#ebfbee;border:1px solid #8ce99a}' +
            '.cb-hint.error{color:#c92a2a;background:#fff5f5;border:1px solid #ffa8a8}' +
            '#catalogue_new_box,#catalogue_current_box{max-width:340px;padding:5px 12px;border-radius:20px;' +
            'background:rgba(224,49,49,.07);border:1px solid rgba(224,49,49,.3)}' +
            '#catalogue_new_box i,#catalogue_current_box i{color:#e03131}' +
            '#catalogue_new_box span{flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}'
        ).appendTo('head');

        $('#cb_stage').append('<div class="cb-hint" id="cb_hint"></div>');
        $('<div class="text-danger small mt-1 d-none" id="cb_error"></div>').insertBefore('#cb_stage');
    }

    function setHint(text, cls) {
        $('#cb_hint').removeClass('done error').addClass(cls || '').text(text);
    }

    function showStage(cb) {
        var $s = $('#cb_stage');
        if (!$s.length || $s.is(':visible')) { if (cb) { cb(); } return; }
        $s.stop(true, true).fadeIn(250, function () { if (cb) { cb(); } });
    }

    function hideStage() {
        $('#cb_stage').stop(true, true).hide();
    }

    function showError(message) {
        $('#cb_error').text(message).removeClass('d-none');
    }

    function clearError() {
        $('#cb_error').addClass('d-none').text('');
    }

    function formatSize(bytes) {
        if (bytes >= 1073741824) { return (bytes / 1073741824).toFixed(2) + ' GB'; }
        if (bytes >= 1048576) { return (bytes / 1048576).toFixed(1) + ' MB'; }
        return Math.max(1, Math.round(bytes / 1024)) + ' KB';
    }

    function resetBall() {
        var ball = document.getElementById('cb_ball');
        var net = document.getElementById('cb_net');
        if (!ball) { return; }
        if (ball.getAnimations) {
            ball.getAnimations().forEach(function (a) { a.cancel(); });
        }
        ball.style.display = 'none';
        if (net) { net.classList.remove('swish'); }
        setHint('', '');
    }

    // PDF ko seedha basket me rakh do (bina animation ke)
    function placeBall() {
        var ball = document.getElementById('cb_ball');
        if (!ball) { return; }
        ball.style.display = 'flex';
        ball.style.transform = 'translate(' + (RIM_X - BALL_W / 2) + 'px,' + (NET_BOTTOM - BALL_H + 6) + 'px)';
    }

    function throwBall(onLanded) {
        var ball = document.getElementById('cb_ball');
        var net = document.getElementById('cb_net');
        if (!ball) { if (onLanded) { onLanded(); } return; }

        resetBall();

        var sx = 8, sy = SCENE_H - BALL_H - 14;          // start (neeche left, ghaas par)
        var rx = RIM_X - BALL_W / 2, ry = RIM_Y - BALL_H - 6; // rim ke thik upar
        var ey = NET_BOTTOM - BALL_H + 6;                // net ke andar rukne ki jagah
        var peak = 4;
        var cy = 2 * peak - 0.5 * (sy + ry);             // arc ka control point

        var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (!ball.animate || reduced) {
            placeBall();
            if (onLanded) { onLanded(); }
            return;
        }

        ball.style.display = 'flex';

        var frames = [], i, t, x, y;
        for (i = 0; i <= 24; i++) {
            t = i / 24;
            x = sx + (rx - sx) * t;
            y = Math.pow(1 - t, 2) * sy + 2 * (1 - t) * t * cy + t * t * ry;
            frames.push({ transform: 'translate(' + x + 'px,' + y + 'px) rotate(' + (t * 360) + 'deg)' });
        }

        var a1 = ball.animate(frames, { duration: 950, easing: 'linear', fill: 'forwards' });
        a1.onfinish = function () {
            var a2 = ball.animate([
                { transform: 'translate(' + rx + 'px,' + ry + 'px) rotate(360deg)' },
                { transform: 'translate(' + rx + 'px,' + ey + 'px) rotate(360deg)' }
            ], { duration: 350, easing: 'cubic-bezier(.4,0,1,1)', fill: 'forwards' });
            a2.onfinish = function () {
                if (net) { net.classList.add('swish'); }
                if (onLanded) { onLanded(); }
            };
        };
    }

    // ---- upload ----
    function stopUploadUi() {
        currentXhr = null;
        $submitBtn.prop('disabled', false);
        $progress.addClass('d-none');
        $bar.css('width', '0%');
    }

    function abortUpload() {
        if (currentXhr) {
            currentXhr.abort();
        }
        stopUploadUi();
    }

    function failUpload(message) {
        stopUploadUi();
        $catalogueInput.val('');
        $temp.val('');
        $newBox.addClass('d-none').removeClass('d-flex');
        resetBall();
        hideStage();
        showError(message);
    }

    function startUpload(file) {
        var url = $catalogueInput.data('uploadUrl');
        if (!url) { return; } // route nahi hai => file form ke saath hi jayegi

        var fd = new FormData();
        fd.append('_token', $('#productForm input[name="_token"]').val());
        fd.append('catalogue', file);

        var xhr = new XMLHttpRequest();
        currentXhr = xhr;

        $submitBtn.prop('disabled', true);
        $progress.removeClass('d-none');
        $bar.css('width', '0%');
        setHint('Uploading 0%', '');

        xhr.open('POST', url);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.upload.onprogress = function (e) {
            if (e.lengthComputable) {
                var pct = Math.round(e.loaded / e.total * 100);
                $bar.css('width', pct + '%');
                setHint('Uploading ' + pct + '%', '');
            }
        };

        xhr.onload = function () {
            var res = {};
            try { res = JSON.parse(xhr.responseText); } catch (err) {}

            if (xhr.status >= 200 && xhr.status < 300 && res.success) {
                stopUploadUi();
                $temp.val(res.temp);
                $catalogueInput.val(''); // file dobara form ke saath na jaye
                $newName.text(file.name + ' (' + formatSize(file.size) + ')');
                setHint('\u2713 PDF uploaded', 'done');
            } else {
                var msg = (res.errors && res.errors.catalogue && res.errors.catalogue[0]) ||
                          res.message || 'Upload failed. Please try again.';
                failUpload(msg);
            }
        };

        xhr.onerror = function () { failUpload('Network error. The upload failed.'); };

        xhr.send(fd);
    }

    // ---- events ----
    $catalogueInput.on('change', function () {
        var file = this.files && this.files[0];

        if (!file) {
            $newBox.addClass('d-none').removeClass('d-flex');
            resetBall();
            hideStage();
            return;
        }

        clearError();
        abortUpload();
        $temp.val('');

        if (!/\.pdf$/i.test(file.name)) {
            $catalogueInput.val('');
            $newBox.addClass('d-none').removeClass('d-flex');
            resetBall();
            hideStage();
            showError('Only PDF files are allowed.');
            return;
        }
        if (file.size > MAX_PDF) {
            $catalogueInput.val('');
            $newBox.addClass('d-none').removeClass('d-flex');
            resetBall();
            hideStage();
            showError('The PDF may not be greater than 2 GB.');
            return;
        }

        $newName.text(file.name + ' (' + formatSize(file.size) + ')');
        $newBox.removeClass('d-none').addClass('d-flex');
        // naya file chuna to purani wali replace ho jayegi, remove flag ki zarurat nahi
        $('#remove_catalogue').val('0');

        // pehle basket dikhao, phir PDF girte hi upload shuru
        showStage(function () {
            throwBall(function () { startUpload(file); });
        });
    });

    // naya select kiya hua file hatao (add + edit dono)
    $('#remove_new_catalogue').on('click', function () {
        abortUpload();
        resetBall();
        hideStage();
        clearError();
        $catalogueInput.val('');
        $temp.val('');
        $newBox.addClass('d-none').removeClass('d-flex');
        $catalogueInput.removeClass('is-invalid');
        $catalogueInput.next('label.error').remove();
    });

    // purani saved PDF hatao (sirf edit page)
    $('#remove_current_catalogue').on('click', function () {
        if (!confirm('Remove the current catalogue?')) {
            return;
        }
        $('#remove_catalogue').val('1');
        $('#catalogue_current_box').remove();
    });

    // validation error ke baad page wapas aaye aur PDF pehle upload ho chuki thi
    if ($temp.length && $temp.val()) {
        $('#cb_stage').show();
        placeBall();
        setHint('\u2713 PDF uploaded', 'done');
        $newName.text('Uploaded PDF (ready to save)');
        $newBox.removeClass('d-none').addClass('d-flex');
    }

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
