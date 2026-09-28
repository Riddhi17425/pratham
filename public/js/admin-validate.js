/**
 * Shared jQuery Validation defaults for the whole admin panel.
 * Loaded once in includes/footer.blade.php (after jQuery + jquery.validate).
 *
 * HOW TO USE IN A FORM (see users/_form.blade.php for a full example):
 *   1. Give the form an id and add `novalidate`:  <form id="bannerForm" novalidate ...>
 *   2. In the same blade file add:
 *        @push('scripts')
 *        <script>
 *            $('#bannerForm').validate({ rules: {...}, messages: {...} });
 *        </script>
 *        @endpush
 * Client validation is only for convenience. Server-side validation in the
 * controller is ALWAYS required and is the real security layer.
 */
$.validator.setDefaults({
    errorElement: 'div',
    errorClass: 'is-invalid',   // Bootstrap 5 red border on the field
    validClass: '',
    ignore: ':hidden:not(select), :disabled',

    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    },

    // Stop double submits: disable the submit button once the form is valid
    submitHandler: function (form) {
        $(form).find('button[type="submit"], button:not([type])').prop('disabled', true);
        form.submit();
    }
});

// Re-enable buttons if the user comes back with the browser Back button
$(window).on('pageshow', function () {
    $('form button').prop('disabled', false);
});

// Remove a server-side error message as soon as the user edits that field
$(document).on('input change', 'input.is-invalid, select.is-invalid, textarea.is-invalid', function () {
    $(this).siblings('.invalid-feedback').filter(function () {
        return !/-error$/.test(this.id || '');
    }).remove();
});
