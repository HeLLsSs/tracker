$('#page').on('show', '#tkr-view-project', function() {
    var container = this;

    // responsive toggle for filters
    $('.filters-check').on('show.bs.collapse', function() {
        $(this).addClass('visible-xs visible-sm');
    });
    $('.filters-check').on('hidden.bs.collapse', function() {
        $(this).removeClass('visible-xs visible-sm');
    });

    $('.pagination a', this).on('click', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation(e);
        
    });

    $('.search-filters form', container).on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var obj = {};
        var qs = [];
        $.each($(this).serializeArray(), function (i, item) {
            var fname = item.name.replace('[]', ''); 
            if (item.value.length > 0) {
                if (typeof obj[fname] == 'string') obj[fname] += ',' + item.value;
                else obj[fname] = item.value;
                qs.push(fname + ':' + item.value);
            }
        });
     
        qs = qs.join('/');

        var loc = window.location.pathname;
        var pattern = 'view';
        var start = loc.lastIndexOf(pattern);
        if (qs != '') qs = '/' + qs;
        var url = loc.substring(0, start + pattern.length) + qs;
        window.history.pushState({}, '', url);
        $.ajax({
            type: "POST",
            url: form.action,
            data: $(form).serialize() + '&origin=search-form',
            success: function(rsp) {
                $('#bugs-list').html(rsp);
                $('.cut-txt').tooltip({
                    // placement: 'right',
                    title: function() {
                        return $(this).text();
                    }
                });
            }
        });
    });

    $('input[type="checkbox"]', container).on('change', function (e) {
        $('.search-filters form', container).submit();
    });

    $('.nav-tabs a', container).on('click', function(e) {
        e.preventDefault();
        $(this).parent().siblings().removeClass("active");
        $(this).parent().addClass("active");
        var href = $(this).attr('href');
        var status = href.substring(href.lastIndexOf('_') + 1, href.length);
        if (status != '') getBugsList(status);
        return false;

    });

    $('.cut-txt').tooltip({
        // placement: 'right',
        title: function() {
            return $(this).text();
        }
    });

    // getBugsList();
});

$('#page').on('show', '#tkr-view-ticket', function() {
    var mePage = this;
    $(this).on('click', '.status-changer a', function (e) {
        var href = $(this).attr('href').replace('#status_', '');
        var text = $(this).text();
        $.ajax({
            url: href,
            success: function(rsp) {
                if (typeof rsp == 'object') {
                    if (rsp.status == 'success') {
                        cos.alert("Le ticket a été enregistré.", 'success');
                        $('#status-btn span:eq(0)').text('Statut : ' + text);
                        $('#status-btn').removeClass('btn-primary');
                        $('#status-btn').removeClass('btn-danger');
                        $('#status-btn').removeClass('btn-warning');
                        $('#status-btn').removeClass('btn-info');
                        $('#status-btn').removeClass('btn-success');

                        switch (rsp.data.status) {
                            case 1: // waiting
                                $('#status-btn').addClass('btn-danger');
                                break;
                            case 2: // assigned
                                $('#status-btn').addClass('btn-info');
                                break;
                            case 3: // client waiting
                                $('#status-btn').addClass('btn-warning');
                                break;
                            case 4: // fixed
                                $('#status-btn').addClass('btn-success');
                                break;
                            case 5: // aborted
                                $('#status-btn').addClass('btn-danger');
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
        });
        e.preventDefault();
    });

    $('.dev-changer a', this).on('click', function (e) {
        var href = $(this).attr('href').replace('#status_', '');
        var text = $(this).text();
        $(this).addClass('active');
        $(this).parent().siblings().find('a').removeClass('active');

        $.ajax({
            url: href,
            success: function(rsp) {
                if (rsp.status == 'success') {
                    $('#dev-btn span:eq(0)').text('Attribué à : ' + text);
                    cos.alert("Le ticket a été enregistré.", 'success');
                    $.ajax({
                        url: 'status-switch',
                        success: function(rsp) {
                            $('#status-switch').html(rsp);
                        }
                    });
                }
            }
        });
        e.preventDefault();
    });
    $('.comment-author span').tooltip({html: true});
    $('form#add-comment', this).on('submit', function(e) {
        e.preventDefault();
        var form = this;
        $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            success: function(rsp) {
                console.log(rsp);
                // if (rsp.status == 'success') {
                    form.reset();
                    $('#comments-list', mePage).html(rsp);
                    $('.comment-author span').tooltip({html: true});
                // }
            }
        });
    });
}); // end view ticket

function getBugsList(status) {
    var url = "view";
    if (!isNaN(parseInt(status))) url += '/' + status;
    $.ajax({
        type: "GET",
        url: url,
        success: function(rsp) {
            $('#bugs-list').html(rsp);
        }
    });
}