function CosList(table) {
    this.container;
    this.table = table;
    this.form;
    this.pager;

    this.init();
}

CosList.prototype = {
    init: function() {
        this.container  = $(this.table).parents('[data-role="page"]');
        this.form       = $('form.delete-form', this.container);
        this.pager      = $('.CitrusPager', this.table);

        console.log("container", this.container);
        console.log("table", this.table);
        console.log("form", this.form);
        console.log("pager", this.pager);

        this.setUp();
    },

    setUp: function() {
        var self = this;

        // check box select all objects
        $(self.table).on('change', '.sel input[type="checkbox"]', function () {
            if (this.checked) {
                $('tbody input[type="checkbox"]', self.table).attr('checked', 'checked');
            } else {
                $('tbody input[type="checkbox"]', self.table).removeAttr('checked');
            } 
            $('tbody input[type="checkbox"]', self.table).each(function () {
                if (this.checked) {
                    $(this).parents('tr').addClass('selected');
                } else {
                    $(this).parents('tr').removeClass('selected');
                }
            });
        });

        $(self.table).on('change', 'tbody input[type="checkbox"]', function () {
            var all = true;
            $('tbody input[type="checkbox"]', self.table).each(function () { 
                all = all && this.checked; 
            });
            if (this.checked) $(this).parents('tr').addClass('selected');
            else $(this).parents('tr').removeClass('selected');
            if (all) $('table.listing .sel input[type="checkbox"]').attr('checked', 'checked');
            else $('table.listing .sel input[type="checkbox"]').removeAttr('checked');
        });

        $(self.form).on('submit', function (e) {
            e.preventDefault();
            var lst = new Array();
            var frm = this;
            $('tbody input[type="checkbox"]:checked', self.table).each(function () { 
                lst.push( 
                    $(this).parents('tr').attr('id').split('_').pop() 
                );
            });
            if (lst.length > 0)
                if (window.confirm("Souhaitez-vous supprimer les éléments sélectionnés ?")) {
                    $.ajax({
                        type: "POST",
                        url: frm.action,
                        data: $(frm).serialize(),
                        // dataType: "json",
                        success: function(rsp) {
                            rsp = $.parseJSON(rsp);
                            cos.loadPage(rsp.return_url);
                        }
                    });
                }
        });

    },

    destroy: function() {

    }
};


// listings
$(document).ready(function () {
    $('#page').on('show', '#cos-object-list', function() {
        var cos_list = new CosList($('.table.listing', this));
        
        $('#page').off('keypress', '.cos-list #search');
        $('#page').on('keypress', '.cos-list #search', function (e) {
            var code = null;
            code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) return false;
            else return true;
        });
        
        $('#page').off('keyup', '.cos-list #search');
        $('#page').on('keyup', '.cos-list #search', function (e) {
            var order = $('table.listing thead th.asc, table.listing thead th.desc'),
                p = {search:$(this).val()};
            if (order.length > 0) {
                p.order = order.attr('rel');
                p.orderType = order.hasClass('asc') ? 'asc' : 'desc';
            }
            p.origin = "search-form";
            $.get(location, p, function ( ret ) {
                $('table.listing tbody, table.listing tfoot').remove();
                $('table.listing').append(ret);
            }, 'html');
        });



        
        return;
        $('table.listing thead th.sortable').off('click');
        $('table.listing thead th.sortable').on('click', function () {
            if (!$(this).hasClass('asc') && !$(this).hasClass('desc')) {
                $('table.listing thead th.asc').removeClass('asc');
                $('table.listing thead th.desc').removeClass('desc');
                $(this).addClass('asc');
            } else if ($(this).hasClass('asc')) {
                $(this).removeClass('asc');
                $(this).addClass('desc');
            } else if ($(this).hasClass('desc')) {
                $(this).removeClass('desc');
                $(this).addClass('asc');
            }
            var p = {
                search:     $('table.listing .action #search').val(), 
                order:      $(this).attr('rel'), 
                orderType:  $(this).hasClass('asc') ? 'asc' : 'desc'
            };
            $.post(location, p, function ( ret ) {
                $('table.listing tbody, table.listing tfoot').remove();
                $('table.listing').append(ret);

            }, 'html');
        });
        
        $('#page').on('click', '.CitrusPager a', function (e) {
            var a = this;
            $.get( this.href, function ( ret ) {
                // $('table.listing tbody, table.listing tfoot').remove();
                // $('table.listing').append(ret);
                $('#page').html(ret);
                window.history.pushState({}, '', a.pathname);
            }, 'html');
            e.stopImmediatePropagation();
            return false;
        });
        
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        }, launchSortable = function () {
            $( "tbody.sortable" ).sortable({
                placeholder: "ui-state-highlight",
                helper: fixHelper,
                update : function () {
                    var ref = this, list = [];
                    $('tr[id]', ref).each(function () { list.push(this.id.split('_').pop());});
                    $.post("sortable.html", { "list" : list.join(",") }, function ( res ) { 
                        $(ref).next().remove();
                        $(ref).replaceWith(res);
                        launchSortable();
                    }, 'html');
                }
            });
        };
        
        launchSortable();

    });
});