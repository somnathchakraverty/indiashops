<script>
    $(document).on('show.bs.dropdown', function () {
        $('#overlay').toggleClass("menu-open");
    });
    $(document).on('hide.bs.dropdown', function () {
        $('#overlay').toggleClass("menu-open");
    });
    $(document).ready(function () {
        $('.user.dropdown').hover(function () {
            $(this).find('.dropdown-menu').stop(true, true).fadeIn(100);
        }, function () {
            $(this).find('.dropdown-menu').stop(true, true).fadeOut(100);
        });
    });

    $(document).ready(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });

        $('#back-to-top').tooltip('show');

    });
    @if( in_array(Route::getCurrentRoute()->getName(),config('notify.routes')) && !isMobile() )
        {{getNotificationSettings(get_defined_vars())}}
    @endif
</script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'hi,kn,mr,pa,sd,ta,te,en',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            gaTrack: true,
            gaId: 'UA-69454797-1'
        }, 'google_translate_element');
    }
</script>

<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '324999011227767');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id=324999011227767&ev=PageView&noscript=1"
    /></noscript>
<!-- End Facebook Pixel Code -->
<script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>