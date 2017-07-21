var App = (function ($) {
    "use strict";

    var _tabs;
    var _filter;
    var _filter_toggle;
    var _filter_fields;
    var _tickets_container;
    var _statistics_container;

    var ajax_loader = _.template($("script.ajax-loader-mask").html());

    var _bind_events = function () {
        $(document).on("click", ".close-tab", _close_tab);
        $(document).on("click", "#filter-toggle", _toggle_filter);
        $(document).on("click", "#show-filters", _toggle_filter_display);
        $(document).on("click", "#refresh-tickets", load_tickets);
        $(document).on("click", ".registration-toggle", _toggle_registration);
        $(document).on("click", ".page", _page);
        $(document).on("keyup", "#search", _search);
        $(document).on("submit", "#registration-form", _register_user);
        $(document).on("change", ".filter-field", _filter_off);
        $(document).on("show.bs.modal", "#create-modal", _init_media_dropzone);
        $(document).on("hidden.bs.modal", "#create-modal", _reset_media_dropzone);
        $(document).on('shown.bs.tab', '.editor-tab', _preview_comment);
        $(document).on('click', '#reset-password', _reset_password);
    };

    var _reset_password = function (e) {
        e.preventDefault();

        var form = $(e.target).parents('form');
        var alert = _.template('<div class="alert alert-dismissible alert-<%=status %>"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><span><%= message %></span></div>');

        form.submit({
            url: Globals.ajax_url,
            action: "support_reset_password",
            method: "post",
            extras: {
                _ajax_nonce: Globals.ajax_nonce
            },
            success: function (response) {
                if(response.data.message != undefined) {
                    $('#reset-pw-alert').html(alert({message: response.data.message, status: 'success'}));
                }
            },
            error: function(xhr) {
                if(xhr.responseJSON.data.message != undefined) {
                    $('#reset-pw-alert').html(alert({message: xhr.responseJSON.data.message, status: 'error'}));
                }
            },
            complete: function () {
                form.find('input[name="username"]').val('');
            }
        });
    }

    var close_preview = function (tabs) {
        $(tabs).find('li.edit a').tab('show');
    };

    var _preview_comment = function (e) {
        var tab = $(e.target);
        var pane = $(tab.attr("href"));

        if(pane.hasClass('preview')) {
            var content = $(pane.prev()).find('.editor-content').val();
            var html = content.match(/<code>([\s\S]*?)<\/code>/g);

            if(html != null) {
                html.forEach(function (block) {
                    block = block.replace(/<code[^>]*>/gi, '').replace(/<\/code>/gi, '');
                    content = content.replace(block, _.escape(block).trim());
                });
            }

            pane.find('.rendered').html(content);
        }
    };

    var _reset_media_dropzone = function(e) {
        var attachments = $(e.target).find("input.attachments");

        Dropzone.forElement("#ticket-media-upload").destroy();
        attachments.val(JSON.stringify(attachments.data("default")));
    };

    var _init_media_dropzone = function (e) {

        var submit_button = $('#create-ticket');

        $(e.target).find('#ticket-media-upload').dropzone({
            addRemoveLinks: true,
            url: Globals.ajax_url + "?action=support_upload_media",

            init: function() {

                this.on('processing', function() {
                    submit_button.prop('disabled', true);
                });

                this.on('complete', function() {
                    submit_button.prop('disabled', false);
                });

                this.on("success", function(file, res) {
                    var media = $(e.target).find("input.attachments");
                    var uploads = JSON.parse(media.val());

                    file.id = res.data.id;

                    uploads.push(res.data.id);
                    media.val(JSON.stringify(uploads));
                });

                this.doingReset = false;

                this.on("removedfile", function(file) {
                    if(!this.doingReset) {
                        $.ajax({
                            url: Globals.ajax_url,
                            dataType: "json",
                            data: {
                                action: "support_delete_media",
                                _ajax_nonce: Globals.ajax_nonce,
                                attachment_id: file.id
                            }
                        });
                    }
                });

                this.reset = function() {
                    this.doingReset = true;
                    this.removeAllFiles();
                    this.doingReset = false;
                };
            }
        });
    };

    var _search = _.debounce(function () {
        load_tickets();
    }, 250);

    var _page = function (e) {
        sessionStorage.setItem("page", $(e.target).data("id"));
        load_tickets();
    };

    var _close_tab = function (e) {
        var tab = $(e.target).closest("li");
        var prev =  tab.prev().find("a");
        var next = tab.next();

        $("#" + tab.data("id")).remove();
        tab.remove();

        if (next.length === 0) {
            prev.tab("show");
        }

        $(".nav-tabs").scrollingTabs('refresh');
    };

    var new_tab = function (data) {
        var li = $("<li class=\"tab\" data-id=\"" + data.id + "\">" +
                        "<a href=\"#" + data.id + "\" data-toggle=\"tab\">" +
                            "<span class=\"title\">" + data.title + "</span>" +
                            "<span class=\"close close-tab\">&times;</span>" +
                        "</a>" +
                    "</li>");
        var panel = $("<div id=\"" + data.id + "\" class=\"tab-pane fade\">" + data.content + "</div>");

        _tabs.find(".ticket-nav-tabs").append(li);
        _tabs.find(".ticket-tab-panels").append(panel);

        $(".nav-tabs").scrollingTabs('refresh');

        li.find("a").tab("show");
    };

    var open_tab = function (id) {
        var tab = _find_tab(id);

        if (tab.length > 0) {
            tab.find("a").tab("show");
        }

        return tab.length > 0;
    };

    var _find_tab = function (id) {
        return $("li.tab").filter(function () {
            return $(this).data("id") === id;
        });
    };
    
    var load_statistics = function () {
        
        var request = {
            url : Globals.ajax_url + "?action=support_display_statistics",
            dataType : "json",
            data: [{
                name : "_ajax_nonce",
                value : Globals.ajax_nonce
            }],
            success: function( response ) {
                _statistics_container.html( response.content )
            },
            complete: function( response ) {},
            error: function( response ) {}
            
        }
                
        $.ajax(request);
    }
    
    var load_tickets = function () {
        var refresh = $("#refresh-tickets").find(".refresh");
        var filter_controls = $("#filter-controls");
        var page = sessionStorage.getItem("page");
        var request = {
            url: Globals.ajax_url + "?action=support_list_tickets",
            dataType: "json",
            data: [{
                name: "_ajax_nonce",
                value: Globals.ajax_nonce
            }, {
                name: "page",
                value: page === undefined ? "1" : page
            }, {
                name: "search",
                value: $("#search").val()
            }],
            success: function (response) {
                _tickets_container.html(response.data);

                if (filter_controls.css("display") === "none") {
                    filter_controls.slideToggle();
                    _tickets_container.hide().fadeToggle();
                }
            },
            complete: function () {
                refresh.removeClass("rotate");
            }
        };

        if (_filter_toggle.hasClass("active")) {
            request.data = $.merge(request.data, _filter.serializeArray());
        }

        refresh.addClass("rotate");
        $.ajax(request);
    };
    
    var adjust_login = function( e ) {
        
        return;
        
        $('#support-login-page').css({
            width: $('body').width(),
            height: $('body').height(),
        });
    }
    
    var _register_user = function (e) {
        e.preventDefault();

        var form = $(e.target);
        var submit = $("#registration-submit");

        submit.prop("disabled", true);

        form.submit({
            url: Globals.ajax_url,
            action: "support_register_user",
            method: "post",
            extras: {
                _ajax_nonce: Globals.ajax_nonce
            },
            success: function (response) {
                window.location.reload();
            },
            complete: function () {
                submit.prop("disabled", false);
            }
        });
    };

    var _filter_off = function () {
        _filter_toggle.removeClass("active");
        sessionStorage.removeItem("page");
    };

    var _toggle_filter = function () {
        _filter_toggle.toggleClass("active");

        load_tickets();
    };

    var _toggle_filter_display = function (e) {
        $("#filters").slideToggle();
    };

    var _toggle_registration = function () {
        $("#login").toggle();
        $("#register").toggle();
    };

    var _time = function () {
        var clock = $("#sys-time");
        var date = $("#sys-date");

        setInterval(function () {
            var time = moment();

            clock.text(time.format("hh:mm:ss a"));
            date.text(time.format("MMMM, Do YYYY"));

        }, 1000);
    };

    var initialize = function () {
        _tabs = $("#tabs");
        _filter = $("#ticket_filter");
        _filter_toggle = $("#filter-toggle");
        _filter_fields = _filter.find(".filter-field");
        _tickets_container = $("#tickets-container");
        _statistics_container = $("#statistics-container");
        

        ajax_loader = _.template($("script.ajax-loader-mask").html());
        _tickets_container.html(ajax_loader(Globals.strings.loading_tickets));

        $(".nav-tabs").scrollingTabs();

        var register_button = $("#show-registration");

        if(register_button.length > 0) {
            register_button.show().insertAfter('#wp-submit')
        }

        Dropzone.autoDiscover = false;

        _time();
        _bind_events();
        load_tickets();
        load_statistics();
        adjust_login();

        setInterval(load_tickets, 1000 * Globals.refresh_interval);
        setInterval(load_statistics, 1000 * Globals.refresh_interval);

    };

    return {
        load_tickets: load_tickets,
        initialize: initialize,
        new_tab: new_tab,
        open_tab: open_tab,
        close_preview: close_preview,
        load_statistics: load_statistics,
        ajax_loader: ajax_loader
    };

})(jQuery);

jQuery(document).ready(function () {
    App.initialize();
});
