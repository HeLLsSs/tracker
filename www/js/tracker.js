$('#page').on('show', '#tkr-view-project', function() {
    var container = this;

    $('.search-filters form', container).on('submit', function(e) {
        e.preventDefault();
        var action = this.action,
            method = this.method,
            data   = $(this).serialize();
        $.ajax({
            type: method,
            url: action,
            data: data,
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

    getBugsList()
});

$('#page').on('show', '#tkr-view-ticket', function() {
    console.log($('.status-changer a', this));
    $('.status-changer a', this).on('click', function (e) {
        e.preventDefault;
    });
});

function getBugsList(status) {
    var url = "tickets";
    if (!isNaN(parseInt(status))) url += '/' + status;
    $.ajax({
        type: "GET",
        url: url,
        success: function(rsp) {
            $('#bugs-list').html(rsp);
        }
    });
}