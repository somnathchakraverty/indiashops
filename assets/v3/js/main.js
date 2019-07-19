jQuery(document).ready(function (e) {
    var attempts = 0;

    function n() {
        var n = e(".cd-dropdown").hasClass("dropdown-is-active") ? !1 : !0;
        e(".cd-dropdown").toggleClass("dropdown-is-active", n), e(".cd-dropdown-trigger").toggleClass("dropdown-is-active", n), n || e(".cd-dropdown").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function () {e(".has-children ul").addClass("is-hidden"), e(".move-out").removeClass("move-out"), e(".is-active").removeClass("is-active")})
    }

    e(".cd-dropdown-trigger").on("click", function (e) {e.preventDefault(), n()}), e(".cd-dropdown .cd-close").on("click", function (e) {e.preventDefault(), n()}), e(".has-children").children("a").on("click", function (n) {
        n.preventDefault();
        var a = e(this);
        a.next("ul").removeClass("is-hidden").end().parent(".has-children").parent("ul").addClass("move-out")
    });
    var a = e(".cd-dropdown-wrapper").hasClass("open-to-left") ? "left" : "right";
    e.menuJs, e(".go-back").on("click", function () {
        var n = e(this);
        e(this).parent("ul").parent(".has-children").parent("ul");
        n.parent("ul").addClass("is-hidden").parent(".has-children").parent("ul").removeClass("move-out")
    }), Modernizr.input.placeholder || (e("[placeholder]").focus(function () {
        var n = e(this);
        n.val() == n.attr("placeholder") && n.val("")
    }).blur(function () {
        var n = e(this);
        ("" == n.val() || n.val() == n.attr("placeholder")) && n.val(n.attr("placeholder"))
    }).blur(), e("[placeholder]").parents("form").submit(function () {
        e(this).find("[placeholder]").each(function () {
            var n = e(this);
            n.val() == n.attr("placeholder") && n.val("")
        })
    }));

    $(document).on('click', '.productgoto', function (e) {
        if (typeof loggedIn != 'undefined' && !loggedIn && attempts < 1 && !$(this).hasClass('no_cb')) {
            attempts++;

            var redirect_url = $(this).attr('href');
            var login_url = '/user/register?redirect_url=' + encodeURIComponent(redirect_url);

            var popup_html = '<div class="modal-content cashback" rel="' + redirect_url + '">';
            popup_html += '<img src="/assets/v3/images/cb_popup.png" usemap="#image-map"/>';
            popup_html += '<map name="image-map">';
            popup_html += '<area target="_blank" onclick="$(\'#exit_popup_modal\').modal(\'hide\')" href="' + login_url + '" coords="53,253,249,291" shape="rect">';
            popup_html += '<area target="_blank" onclick="$(\'#exit_popup_modal\').modal(\'hide\')" href="' + redirect_url + '" coords="257,253,320,291" shape="rect">';
            popup_html += '</map>';
            popup_html += '<a role="button" target="_blank" href="' + redirect_url + '" class="close popupright10" onclick="$(\'#exit_popup_modal\').modal(\'hide\')"  aria-label="Close"> <span aria-hidden="true">×</span></a>';
            popup_html += '</div>';

            $("#poup_content").html(popup_html);
            $("#exit_popup_modal").modal('show');

            e.preventDefault();
        }
    });

    $('#exit_popup_modal').on('hidden.bs.modal', function () {
        $("#poup_content .modal-content").html('');
    })
});

$.fn.isInViewport = function() {
    if( typeof $(this).offset() == 'undefined') return false;
    
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
};

$.fn.menuJs = function (e) {
    e(".cd-dropdown-content").menuAim({
        activate: function (n) {e(n).children().addClass("is-active").removeClass("fade-out"), 0 == e(".cd-dropdown-content .fade-in").length && e(n).children("ul").addClass("fade-in")},
        deactivate: function (n) {e(n).children().removeClass("is-active"), (0 == e("li.has-children:hover").length || e("li.has-children:hover").is(e(n))) && (e(".cd-dropdown-content").find(".fade-in").removeClass("fade-in"), e(n).children("ul").addClass("fade-out"))},
        exitMenu: function () {return e(".cd-dropdown-content").find(".is-active").removeClass("is-active"), !0},
        submenuDirection: 'right'
    })
}