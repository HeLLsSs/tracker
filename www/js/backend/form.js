$.datepicker.setDefaults({ dateFormat: 'dd/mm/yy', onSelect : function () { var self = this; setTimeout(function () {$(self).triggerHandler('blur'); },0); }});

$.datepicker.regional['fr'] = {clearText: 'Effacer', clearStatus: '',
	closeText: 'Fermer', closeStatus: 'Fermer sans modifier',
	prevText: '&lt; Préc', prevStatus: 'Voir le mois précédent',
	nextText: 'Suiv &gt;', nextStatus: 'Voir le mois suivant',
	currentText: 'Courant', currentStatus: 'Voir le mois courant',
	monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
	'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
	monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
	'Jul','Aoû','Sep','Oct','Nov','Déc'],
	monthStatus: 'Voir un autre mois', yearStatus: 'Voir un autre année',
	weekHeader: 'Sm', weekStatus: '',
	dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
	dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
	dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
	dayStatus: 'Utiliser DD comme premier jour de la semaine', dateStatus: 'Choisir le DD, MM d',
	dateFormat: 'dd/mm/yy', firstDay: 1, 
	changeMonth: true,
	changeYear: true,
	onSelect : function () { $(this).triggerHandler('blur') },
	initStatus: 'Choisir la date', isRTL: false};
$.datepicker.setDefaults($.datepicker.regional['fr']);

$.extend($.validator.messages, {
    required:"Ce champ est obligatoire.",
    remote: "Vous ne pouvez choisir cette valeur",
    email: "Saisissez une adresse mail valide",
    url: "Saisissez une adresse URL valide.",
    date: "Saisissez une date valide.",
    checklibelle: 'Ce libelle existe déjà',
    checkmail: 'Cet e-mail à déjà été utilisé',
    checkmail_renew: 'Cet e-mail a déjà été utilisé',
    dateISO: "Saisissez une date valide (ISO).",
    number: "Saisissez un nombre valide.",
    digits: "Saisissez uniquement des chiffres",
    creditcard: "Saisissez un numéro de carte valide",
    equalTo: "Saisissez de nouveau la même valeur",
    accept: "Saisissez une valeur avec une extension correcte.",
    condgene: "Vous devez accepter les conditions générales d'utilisation.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});

/* Created by jankoatwarpspeed.com */
/* gestion des selects many */

var selectMany_Update = function ( select, input, recap ) {
	var list = input.val() ? input.val().split(',') : new Array();
	recap.empty();
	for (k in list) {
		recap.append(
			$('<span></span>').addClass('many-item').attr( 'ident', list[k] ).append(
				obj = $('<span></span>').addClass('elem').html( $('option[value=' + list[k] + ']', select).html() ),
				$('<span></span>').addClass('separ').html(', ')
			)
		);
	}
}, selectMany_Exec = function ( cont ) {
	if (!cont) cont = document;
	$('select.selectMany', cont).live('change', function () {

		var res = $('input[type="hidden"]', $(this).parents('div.form-group')),
			list = res.val() ? res.val().split(',') : new Array(),
			val = this.options[this.selectedIndex].value,
			recap = $('div.many', $(this).parents('div.form-group'));
		if (this.selectedIndex > -1 && val && $.inArray( val , list ) == -1) list.push( val );
		res.val( list.join(',') );
		this.selectedIndex = 0;
		selectMany_Update( $(this), res, recap );
	});

	$('.form-group div.many', cont).live('click', function (e) {
		var cible = $(e.target).hasClass('elem') ? $(e.target) : false;
		if (cible) {
			cible.parent().remove();
			var list = new Array(), recap = $(this), input = recap.prev(), select = input.prev();
			$('span.many-item', select.parent()).each(function () { list.push( $(this).attr('ident') ); });
			input.val( list.join(',') );
			selectMany_Update( select, input, recap );
		}
	});
}, checkMany_Edit = function (checks, input) {
	var list = [];
	checks.each(function () { 
	    if (this.checked) list.push(this.value); 
	});
	input.val( list.join(',') );
}, checkMany_Exec = function ( cont ) {
	if (!cont) cont = document;
	var checks = $('.CheckMany', cont);
    $.each(checks, function(i, elt) {
        c = $(elt);
    	$('input[type="checkbox"][value="all"]', c).live('change', function () {
    		if (this.checked) $('input[type="checkbox"]', c).attr('checked', 'checked').trigger('change.check');
    		else $('input[type="checkbox"]', c).removeAttr('checked').trigger('change.check');
    		checkMany_Edit( $('input[type="checkbox"][value!="all"]', c), $('input[type="hidden"]', c.parent()) );
    	});
    	$('input[type="checkbox"][value!="all"]', c).live('change', function () {
    		if (this.checked) {
    			if ($('input[type="checkbox"][value!="all"]:checked', c).length == $('input[type="checkbox"][value!="all"]', c).length)
    				$('input[type="checkbox"][value="all"]', c).attr('checked', 'checked');
    		}
    		else $('input[type="checkbox"][value="all"]', c).removeAttr('checked');
    		checkMany_Edit( $('input[type="checkbox"][value!="all"]', c), $('input[type="hidden"]', c.parent()) );
    	});
    }); 
}, launchForm = function ( cont ) {
	if (!cont) cont = document;

    $('.form-object', cont).on('submit', function() {
        if ($(this).valid()) {
            var form = this;
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                dataType: "json",
                success: function(rsp) {
                    cos.alert(rsp.message, rsp.status);
                    cos.loadPage(rsp.return_url);
                },
                error: function() {

                }
            });
        }
        return false;
    });
	
	$.validator.addMethod("checkAdminUserLogin", function(value, element) { 
        var data = {login: value};
	    var form = $(element).parents('form');
        var id = $('[name=id]', form).val();
        if ( id != '' ) data.id = id;
        
        var rsp = $.ajax({
            url: rootUrl + 'backend/AdminUser/loginExists', 
            type: 'POST',
            data: data, 
            async: false
        }).responseText;
        return rsp != '1';
	}, "Cet identifiant est déjà utilisé.");
    var forms = $('form', cont);
    
    forms.not('#loginForm').each(function(i, item) {
        var rules = {
            login:{
                checkAdminUserLogin: true
            }
        };
        if ($(item).hasClass('novalidaterules')) {
    	    rules = {};
    	}
    	$('form', cont).validate({
    	    onkeyup: false,
    	    rules: rules,
            invalidHandler: function(e, v) {
                $('.form-group').removeClass('has-error');
                $.each(v.errorList, function(i, item) {
                    $(item.element).parents('.form-group').addClass('has-error');
                });

            }
    	});
    	selectMany_Exec(cont);
    	checkMany_Exec( cont );
    	
        tinymce.editors = [];
    	$( 'textarea.wysiwyg', item ).tinymce({
            statusbar: false,
            menubar: false,
            language: 'fr_FR',
            height: 250,
            plugins: "link image filemanager",
            toolbar: "undo redo | styleselect | bold italic underline | link unlink anchor | image | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent"
        });


    	$( 'input.date', item ).datepicker();
    });
};

(function($) {
    $.fn.formToWizard = function(options) {
        options = $.extend({  
            submitButton: "" 
        }, options); 
        
        var element = this;

        var steps = $(element).find("fieldset");
        var count = steps.size();
        var submmitButtonName = "#" + options.submitButton;
        $(submmitButtonName).hide();

        // 2
        $(element).before("<ul id='steps'></ul>");

        steps.each(function(i) {
            $(this).wrap("<div id='step" + i + "'></div>");
            $(this).append("<p id='step" + i + "commands'></p>");

            // 2
            var name = $(this).find("legend").length ? $(this).find("legend").html() : false;
            $("#steps").append("<li id='stepDesc" + i + "'>Etape " + (i + 1) + ( name ? "<span>" + name + "</span>" : "" ) + "</li>");

            if (i == 0) {
                createNextButton(i);
                selectStep(i);
            }
            else if (i == count - 1) {
                $("#step" + i).hide();
                createPrevButton(i);
                createSubmitButton(i);
            }
            else {
                $("#step" + i).hide();
                createPrevButton(i);
                createNextButton(i);
            }

			$("#step" + i).validate();
        });

        function createSubmitButton(i) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append($(submmitButtonName).css('float', 'right'));
        }

        function createPrevButton(i) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<button id='" + stepName + "Prev' class='prev'>< Précédent</button>");

            $("#" + stepName + "Prev").bind("click", function(e) {
				if ($("#" + stepName).data('validator') && $("#" + stepName).data('validator').form()) {
	                $("#" + stepName).hide();
	                $("#step" + (i - 1)).show();
	                $(submmitButtonName).hide();
	                selectStep(i - 1);
				}
				e.stopImmediatePropagation();
				return false;
            });
        }

        function createNextButton(i) {
            var stepName = "step" + i;
            $("#" + stepName + "commands").append("<button  id='" + stepName + "Next' class='next'>Suivant ></a>");

            $("#" + stepName + "Next").bind("click", function(e) {
				if ($("#" + stepName).data('validator') && $("#" + stepName).data('validator').form()) {
	                $("#" + stepName).hide();
	                $("#step" + (i + 1)).show();
	                if (i + 2 == count)
                    $(submmitButtonName).show();
	                selectStep(i + 1);
				}
				e.stopImmediatePropagation();
				return false;
            });
        }

        function selectStep(i) {
            $("#steps li").removeClass("current");
            $("#stepDesc" + i).addClass("current");
        }

    }
})(jQuery);

jQuery.validator.addMethod( "date", 
	function(value, element) { 
		var checkDate = function (_date) {
			reg = new RegExp(/^[0-3]{1}[0-9]{1}[\/][0-1]{1}[0-9]{1}[\/][0-9]{4}$/);
			if(!reg.test(_date)) return false;
			tabDate = _date.split('/');
			dateTest = new Date(tabDate[2], tabDate[1] - 1, tabDate[0]);
			if( parseInt(tabDate[0], 10) != parseInt(dateTest.getDate(), 10)
				|| parseInt(tabDate[1], 10) != parseInt(dateTest.getMonth(), 10) + parseInt(1, 10)
				|| parseInt(tabDate[2], 10) != parseInt(dateTest.getFullYear(), 10) ) return false;
			return true;
		};
		if ($(element).hasClass('required')) return checkDate( value );
		else if (element.value != '') return checkDate( value );
		else return true;
	} 
);
	
$(document).ready(function () {
	/*$('.form-object').on('submit', function() {
        if ($(this).valid()) {
            var form = this;
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(rsp) {
                    console.log(rsp);
                    $('#page').html(rsp);
                },
                error: function() {

                }
            });
        }
        return false;
    });
	launchForm();*/
});