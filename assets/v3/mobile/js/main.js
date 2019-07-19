jQuery(document).ready(function (e) {
    var attempts = 0;

    $(document).on('click', '.productgoto', function (e) {
        if (typeof loggedIn != 'undefined' && !loggedIn && attempts < 1 && !$(this).hasClass('no_cb')) {
            attempts++;

            var redirect_url = $(this).attr('href');
            var login_url = '/user/register?redirect_url=' + encodeURIComponent(redirect_url);

            var popup_html = '<div class="modal-content cashback">';
            popup_html += '<img src="/assets/v3/mobile/images/cb_popup_m_new.png" usemap="#image-map"/>';
            popup_html += '<map name="image-map">';
            popup_html += '<area target="_blank" href="' + login_url + '" coords="42,174,217,206" shape="rect">';
            popup_html += '<area target="_blank" href="' + redirect_url + '" coords="225,171,279,206" shape="rect">';
            popup_html += '</map>';
            popup_html += '</div>';

            $("#cb_popup").html(popup_html);
            $("#cb_modal").modal('open');

            e.preventDefault();
        }
    });

    $('#back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
});

$.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();
    return elementBottom > viewportTop && elementTop < viewportBottom;
};