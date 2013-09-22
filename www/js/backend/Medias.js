
// $(document).ready(function () {
function launchMediaForm() {
    // configuration de l'upload
    var mediaObj = {
        'video' : {
            'ident' : '1',
            'label' : ['Ajouter une vidéo', 'Déposez une vidéo pour l\'envoyer'],
            'ext' : ['avi','mpg', 'ogg', 'mp4'],
            'uploadMini' : true,
            'form' : ['Libellé', false, 'Vidéo', true, false]
        },
        'url' : {
            'ident' : '2',
            'form' : ['Libellé', true,  false, true, false]
        },
        'image' : {
            'ident' : '3',
            'label' : ['Ajouter une image', 'Déposez une image pour l\'envoyer'],
            'ext' : ['gif','jpg','jpeg','png'],
            'form' : ['Libellé', false, 'Image', false, false]
        },
        'doc' : {
            'ident' : '4',
            'label' : ['Ajouter un document', 'Déposez un document pour l\'envoyer'],
            'ext' : ['doc','docx','odt','txt','pdf','rtf','xls'],
            'form' : ['Libellé', false, 'Document', false, false]
        },
        'lnkvideo' : {
            'ident' : '5',
            'form' : ['Libellé', true, false, false, true]
        },
        'uploadmessage' : {
            typeError: "Le fichier «&nbsp;<i>{file}</i>&nbsp;» n'a pas une extension reconnue. Seules les extensions <strong>{extensions}</strong> sont autorisées.",
            sizeError: "Le fichier «&nbsp;<i>{file}</i>&nbsp;» est trop volumineux, Le poid maximum est de <strong>{sizeLimit}</strong>.",
            minSizeError: "Le fichier «&nbsp;<i>{file}</i>&nbsp;» est trop petit, le poid minimum est de <strong>{minSizeLimit}</strong>.",
            emptyError: "Le fichier «&nbsp;<i>{file}</i>&nbsp;» est vide.",
            onLeave: "Des fichiers sont en cours d'upload. Ils seront perdus si vous annulez"            
        },
        'showMessage' : function ( message ) {

            $( "#uploadDialog" ).remove();
            var modal_content = '<div class="modal-dialog">' +
                                    '<div class="modal-content">' +
                                      '<div class="modal-header">' +
                                        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                                        '<h4 class="modal-title">Information de téléversement</h4>' +
                                      '</div>' +
                                      '<div class="modal-body">' +
                                        '<p>' + message + '</p>' +
                                      '</div>' +
                                      '<div class="modal-footer">' +
                                        '<button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>' +
                                      '</div>' +
                                    '</div>' +
                                  '</div>';
            $('<div></div>').addClass('modal fade')
                .attr('title', 'Information de téléversement')
                .html( modal_content ).appendTo('body')
                .modal({
                    backdrop: false
                });
        },
        'onComplete' : function (id, fileName, responseJSON) {
            if( responseJSON.success ) {
                loadUpload( $('input[name="path"]'), responseJSON.libelle);
                $('.inp_path .qq-upload-list' ).empty();
            }
        },
        'onCompleteMini' : function (id, fileName, responseJSON) {
            if( responseJSON.success ) {
                loadUpload( $('input[name="path_thumb"]'), responseJSON.libelle);
                $('.inp_pathMini .qq-upload-list' ).empty();
            }
        },
        'onProgress': function(id, fileName, loaded, total) {
            console.log(arguments);
        }
    };
    var loadUpload = function (recept, libelle) {
        recept.val( libelle );
        if(recept.data('uploadConfig')) {
            var option = recept.data('uploadConfig');
            $('.retail', recept.parents('.formRow')).remove();
            switch ( option.ident ) {
                case mediaObj.image.ident :
                    var ret = $('<div></div>').addClass('retail'),
                        url = rootUrl  + 'upload/' + libelle,
                        img = $('<img />').attr({'src':url}).appendTo( ret );
                    recept.parents('.formRow').append( ret );
                break;
                case mediaObj.doc.ident :
                case mediaObj.lnkvideo.ident :
                case mediaObj.url.ident :
                case mediaObj.video.ident :
                    var ret = $('<div></div>').addClass('retail'),
                        url = rootUrl  + 'upload/' + libelle,
                        img = $('<a />').attr({'href':url}).html(libelle).appendTo( ret );
                    recept.parents('.formRow').append( ret );
                break;
                default : 
                    alert('Ce type de média n\'est pas pris en compte.\nVeuillez contacter un administrateur');
                    return;
                break;
            }
        }
    }, initForm = function () {
        if ($('input[name="path"]') != '') loadUpload( $('input[name="path"]'), $('input[name="path"]').val());
        if ($('input[name="path_mini"]') != '') loadUpload( $('input[name="path_mini"]'), $('input[name="path_mini"]').val());
    };

    $('select#type_id').bind('change', function () {
        $('.inp_path .televersement').trigger('upload.config');
    });
    
    $('.inp_path .televersement').bind('upload.config', function (e, b) {
        var config;
        switch ( $('select#type_id').val() ) {
            case mediaObj.video.ident :     option = mediaObj.video;    break;
            case mediaObj.url.ident :       option = mediaObj.url;      break;
            case mediaObj.image.ident :     option = mediaObj.image;    break;
            case mediaObj.doc.ident :       option = mediaObj.doc;      break;
            case mediaObj.lnkvideo.ident :  option = mediaObj.lnkvideo; break;
            default : 
                alert('Ce type de média n\'est pas pris en compte.\nVeuillez contacter un administrateur');
                return;
            break;
        }
        $('input[name="path"]').data('uploadConfig', option);
        $('label', $('#libelle').parents('.form-group')).html( option.form[0] );
        
        if (option.form[1]) $('input[name="url"]').parents('.form-group').show();
        else $('input[name="url"]').parents('.form-group').hide();
        
        if (option.form[2]) {
            $('label', $('input[name="path"]').parents('.form-group')).html( option.form[2] );
            $('input[name="path"]').parents('.form-group').show();
            var uploader = new qq.FileUploader({
                element: this,
                allowedExtensions: option.ext,
                action: rootUrl + 'backend/Medias/upload',
                multiple: false,
                textButton: '<button class="btn btn-danger"><i class="icon-upload"></i>' + option.label[0] + '</button>',
                textDropZone: option.label[1],
                onComplete: mediaObj.onComplete,
                messages: mediaObj.uploadmessage ,
                showMessage : mediaObj.showMessage,
                onProgress : mediaObj.onProgress
            });
        } else {
            $('input[name="path"]').removeData('uploadConfig');
            $('input[name="path"]').parents('.form-group').hide();
            $(this).empty();
        }
        
        if (option.form[3]) {
            $('input[name="path_thumb"]').parents('.form-group').show();
            option = mediaObj.image;
            $('input[name="path_thumb"]').data('uploadConfig', option);
            var uploader = new qq.FileUploader({
                element: $('.inp_pathMini .televersement').get(0),
                allowedExtensions: option.ext,
                action: rootUrl + 'backend/Medias/upload',
                multiple: false,
                textButton: '<button class="btn btn-danger"><i class="icon-upload"></i>' + option.label[0] + '</button>',
                textDropZone: option.label[1],
                onComplete: mediaObj.onCompleteMini,
                messages: mediaObj.uploadmessage ,
                showMessage : mediaObj.showMessage,
                onProgress : mediaObj.onProgress
            });
        }
        else {
            $('input[name="path_thumb"]').removeData('uploadConfig');
            $('input[name="path_thumb"]').parents('.form-group').hide();
            $('input[name="path_thumb"]').empty();
        }
        
        if (option.form[4]) $('[name="external_type"]').parents('.form-group').show();
        else $('[name="external_type"]').parents('.form-group').hide();
        
        if (b) initForm();
    }).trigger('upload.config', [true]);
    
    
}