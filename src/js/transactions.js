jQuery.noConflict();

jQuery(document).ready(function ($) {

    $(document).on('click', '.select-accounts', function (e) {
        e.preventDefault;
        $('.account-selector option').prop('selected', true);
        $('.account-selector').trigger('chosen:updated');
    });
    $(document).on('click', '.reset-accounts', function (e) {
        e.preventDefault;
        $('.account-selector option').prop('selected',false);
        $('.account-selector').trigger('chosen:updated');
    });
});