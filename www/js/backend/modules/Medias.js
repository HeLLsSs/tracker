
$(document).ready(function () {
    
    // configuration de l'upload
    var mediaObj = {
        'video' : {
            'ident' : '1',
            'label' : ['Ajouter une vidéo', 'Déposez une vidéo pour l\'envoyer'],
            'ext' : ['avi','mpg', 'ogg', 'mp4'],
            'uploadMini' : true,
            'form' : ['Libellé', false, 'Vidéo', false, false]
        },
        'url' : {
            'ident' : '2',
            'form' : ['Libellé', true,  false, false, false]
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
            'ext' : ['doc','docx','odt','txt','pdf','rtf','xls','pptm', 'ppt', 'mp4'],
            'form' : ['Libellé', false, 'Document', false, false]
        },
        'lnkvideo' : {
            'ident' : '5',
            'form' : ['Libellé', true, false, false, true]
        },
        'uploadmessage' : {
            typeError: "{file} n'as pas une extension reconnue. Seul les extensions {extensions} sont autorisés.",
            sizeError: "{file} est trop volumineux, Le poid maximum est de {sizeLimit}.",
            minSizeError: "{file} est trop petit, le poid minimum est de {minSizeLimit}.",
            emptyError: "{file} est vide.",
            onLeave: "Des fichiers sont en cours d'upload. Ils seront perdus si vous annulez"            
        },
        'showMessage' : function ( message ) {
            $( "#dialog:ui-dialog" ).dialog( "destroy" );
            $('<div></div>')
                .attr('title', 'Information de téléversement')
                .append( $('<p></p>').html( message ) )
                .dialog({ modal: true, buttons: { Ok: function() { $( this ).dialog( "close" ); } } });
        },
        'onComplete' : function (id, fileName, responseJSON) {
            if( responseJSON.success ) {
                loadUpload( $('input[name="path"]'), responseJSON.libelle);
                $('.inp_path .qq-upload-list' ).empty();
            }
        },
        'onCompleteMini' : function (id, fileName, responseJSON) {
            if( responseJSON.success ) {
                loadUpload( $('input[name="path_mini"]'), responseJSON.libelle);
                $('.inp_pathMini .qq-upload-list' ).empty();
            }
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
        $('label', $('#libelle').parent()).html( option.form[0] );
        
        if (option.form[1]) $('input[name="url"]').parent().show();
        else $('input[name="url"]').parent().hide();
        
        if (option.form[2]) {
            $('label', $('input[name="path"]').parent()).html( option.form[2] );
            $('input[name="path"]').parent().show();
            var uploader = new qq.FileUploaderBasic({
                element: this,
                allowedExtensions: option.ext,
                action: rootUrl + 'backend/Medias/upload',
                multiple: false,
                textButton: '<i class="icon-upload"></i>' + '<span>' + option.label[0] + '</span>',
                textDropZone: option.label[1],
                onComplete: mediaObj.onComplete,
                messages: mediaObj.uploadmessage ,
                showMessage : mediaObj.showMessage,
                progress: function() {
                    console.log('toto');
                }
            });
        } else {
            $('input[name="path"]').removeData('uploadConfig');
            $('input[name="path"]').parent().hide();
            $(this).empty();
        }
        
        if (option.form[3]) {
            $('input[name="path_mini"]').parent().show();
            option = mediaObj.image;
            $('input[name="path_mini"]').data('uploadConfig', option);
            var uploader = new qq.FileUploaderBasic({
                element: $('.inp_pathMini .televersement').get(0),
                allowedExtensions: option.ext,
                action: rootUrl + 'backend/Medias/upload',
                multiple: false,
                textButton: '<i class="icon-upload"></i>' + option.label[0],
                textDropZone: option.label[1],
                onComplete: mediaObj.onCompleteMini,
                messages: mediaObj.uploadmessage ,
                showMessage : mediaObj.showMessage
            });
        }
        else {
            $('input[name="path_mini"]').removeData('uploadConfig');
            $('input[name="path_mini"]').parent().hide();
            $('input[name="path_mini"]').empty();
        }
        
        if (option.form[4]) $('[name="external_type"]').parent().show();
        else $('[name="external_type"]').parent().hide();
        
        if (b) initForm();
    }).trigger('upload.config', [true]);
    
    
});