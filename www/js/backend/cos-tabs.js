function CosTabs(elt, options) {
    this.tabs_container = $(elt);
    this.options = $.extend({}, $.fn.cosTabs.defaults, options);
    this.tabs = $('.cos-tab', this.tabs_container);
    this.init();
}

CosTabs.prototype = {
    init: function() {
        this.tabs.hide();
        this.tabs.first().show();
        this.createTabs();
    },
    
    createTabs: function() {
        var ul = $('<ul class="cos-tabs-bar"></ul>');
        var has_active = false;
        var index = 0;
        this.tabs.each(function(i, tab) {
            var title = $(tab).data('title');
            var li = $('<li><a href="#">' + title + '</a></li>');
            var is_active = $(tab).data('active');
            if (is_active) {
                li.addClass('active');
                has_active = true;
                index = i;
            }
            ul.append(li)
        });
        if (!has_active) ul.children('li').first().addClass('active');
        this.showTab(index);
        this.tabs_container.prepend(ul);
        this.bindTabsEvents();
    },
    bindTabsEvents: function() {
        var me = this;
        $('ul.cos-tabs-bar li a', this.tabs_container).each(function(i, lnk) {
            $(lnk).on('click', function() {
                me.showTab(i);
                $(this).parent().siblings('li').removeClass('active');
                $(this).parent().addClass('active');
                return false;
            });
        });
    },
    showTab: function(index, callback) {
        var newTab = this.tabs.get(index);
        this.tabs.hide();
        $(newTab).show();
        if (typeof callback == 'function') {
            callback.call($(newTab));
        }
    },
    goToTab: function(index, callback) {
        var tabs_li = $('ul.cos-tabs-bar li', this.tabs_container);
        var active = tabs_li.get(index);
        tabs_li.removeClass('active');
        $(active).addClass('active');
        this.showTab(index, callback);
    }
}

$.fn.cosTabs = function ( option ) {
    return this.each(function () {
        var $this = $(this), 
            data = $this.data('cosTabs'),
            options = typeof option == 'object' && option;
        if (!data) $this.data('cosTabs', (data = new CosTabs(this, options)))
        if (typeof option == 'string') data[option]();
    });
};

$.fn.cosTabs.Constructor = CosTabs;
$.fn.cosTabs.defaults = {};

$(document).ready(function() { $('.cos-tabs').cosTabs(); });