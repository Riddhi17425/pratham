/**
 * Settings page scripts.
 * Needs: jQuery + jQuery Validate.
 * Only registers the custom validation rules used by the settings form.
 */

$(document).ready(function () {

    if ($.validator) {
        $.validator.addMethod('phoneNumber', function (value, element) {
            return this.optional(element) || /^[0-9+\-()\s]{7,20}$/.test(value);
        }, 'Please enter a valid phone number.');

        // Comma separated office numbers, e.g. "0261-1234567, 0261-7654321"
        $.validator.addMethod('officeNumbers', function (value, element) {
            return this.optional(element) ||
                /^[0-9+\-()\s]{7,20}(\s*,\s*[0-9+\-()\s]{7,20})*$/.test(value);
        }, 'Enter valid office numbers separated by commas.');
    }
});
