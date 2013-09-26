$('#page').on('show', '#tkr-view-project', function() {
    var container = this;

    $('.search-filters form', container).on('submit', function(e) {
        e.preventDefault();
        var form = this;
        $.ajax({
            type: "POST",
            url: form.action,
            data: $(form).serialize() + '&origin=search-form',
            success: function(rsp) {
                $('#bugs-list').html(rsp);
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
        if (status != '') {
            getBugsList(status);
        }
        return false;

    });

    // getBugsList();
});

$('#page').on('show', '#tkr-view-ticket', function() {
    console.log($('.status-changer a', this));
    $(this).on('click', '.status-changer a', function (e) {
        var href = $(this).attr('href').replace('#status_', '');
        var text = $(this).text();
        $.ajax({
            url: href,
            success: function(rsp) {
                if (typeof rsp == 'object') {
                    if (rsp.status == 'success') {
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
                    $('#dev-btn span:eq(0)').text(text);
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
});

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