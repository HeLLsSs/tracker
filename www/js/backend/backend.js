var cos;

$(document).ready(function() {
    $('.dropdown').on('mouseover', function() {
        $(this).addClass('open');
    });
    $('.dropdown').on('mouseout', function() {
        $(this).removeClass('open');
    });

    $('textarea:not(.wysiwyg), [type="text"], [type="email"], [type="password"]').addClass('form-control');

    $('#loginForm #login').focus();

    cos = new CosBackend();

    $('#page').on('show', '#cos-object-form', function() {
        launchForm();
        if ($(this).hasClass('medias')) {
            launchMediaForm();
        }
    });

    $('#page').on('hide', '#cos-object-form', function() {
        console.log('hiding page #edit-form');
        tinyMCE.editors = [];
        /*for (var i in tinyMCE.editors) {
            tinyMCE.editors[i].destroy();
        }*/
    });
    $('[data-role="page"]').trigger('show');
});

