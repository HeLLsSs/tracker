function CosBackend() {
    this.main_frame;
    this.navbar;
    this.current_page;
    this.spinner = null;

    this.spin_timeout;
    this.init();
}

CosBackend.prototype = {
    init: function() {
        this.main_frame = $('#page');
        this.navbar = $('#main-nav');
        this.ajax_links = [
            '#main-nav a', '.listing a', 
            '.btn-add', '.form-object .btn-cancel', 
            '.breadcrumb a', '.back-btn a'
        ];

        var self = this;

        $(window).on('popstate', function() {
            self.loadPage(window.location.pathname);
        });
        
        console.log(this.ajax_links);
        $(document).on('click', this.ajax_links.join(','), function(e) {
            e.preventDefault();
            self.loadPage(this.pathname);
        });

    },
    loadPage: function(url, success, error) {
        var self = this;
        self.activateNavbarLink(url);
        window.history.pushState({}, '', url);
        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function() {
                $('[data-role="page"]', self.main_frame).trigger("hide");
                self.spin_timeout = window.setTimeout(function() {
                    self.main_frame.html('');
                    self.showSpinner();
                }, 100);
            },
            success: function(rsp) {
                window.clearTimeout(self.spin_timeout);
                $(window).scrollTop(0);
                self.hideSpinner();
                self.main_frame.html(rsp);
                if ($(rsp).data('role') == 'page') {
                    var id = $(rsp).attr('id');
                    $('#' + id, self.main_frame).trigger("show");
                }
                
                $('textarea:not(.wysiwyg), input[type="text"], input[type="password"]').addClass('form-control');
            }
        });
    },

    showAlert: function(type, message) {
        if ($('.cos-alert')) $('.cos-alert').fadeOut(500, function() {
            $(this).remove();
        });
        var notice = $('<div class="cos-alert alert alert-' + type + '">' + message + '</div>');
        $('body').append(notice);
        notice.fadeIn(500, function() {
            window.setTimeout(function() {
                notice.fadeOut(500);
            }, 3000);
        });
    },

    showSpinner: function() {
        var opts = {
              lines: 17, // The number of lines to draw
              length: 0, // The length of each line
              width: 6, // The line thickness
              radius: 17, // The radius of the inner circle
              corners: 1, // Corner roundness (0..1)
              rotate: 90, // The rotation offset
              direction: 1, // 1: clockwise, -1: counterclockwise
              color: '#000', // #rgb or #rrggbb
              speed: 0.8, // Rounds per second
              trail: 27, // Afterglow percentage
              shadow: false, // Whether to render a shadow
              hwaccel: false, // Whether to use hardware acceleration
              className: 'spinner', // The CSS class to assign to the spinner
              zIndex: 2e9, // The z-index (defaults to 2000000000)
              top: 'auto', // Top position relative to parent in px
              left: 'auto' // Left position relative to parent in px
        };
        var target = document.getElementById('page');
        this.spinner = new Spinner(opts).spin(target);
    },

    hideSpinner: function() {
        if (this.spinner != null) this.spinner.stop();
    },

    activateNavbarLink: function(href) {
        $('li', this.navbar).removeClass('active');
        $('a[href="' + href + '"]', this.navbar).parent().addClass('active');
    }
};