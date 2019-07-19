@extends($layout_file)
@section('page_content')
    <style type="text/css">
        .linkbg { width: 100%; background: #fff; margin-top: 0 !important; padding-top: 15px !important; clear: both; display: inline-block; border-radius: 4px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) }
        .cashback { width: 100%; margin: 10px 0 40px; padding: 22px; border-radius: 4px; background-color: #fff; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); overflow: hidden }
        .v-card-title { display: inline-block; width: 50% }
        .v-card-title h4 { margin-top: 0 }
        .v-card i { font-size: 30px; float: left; margin: 0 10px 0 0; color: #ff3a34 }
        .user-pro-pic { margin: 10px 0 0 15px !important }
        .fildname { width: 100%; border-radius: 3px !important; height: 40px !important; font-size: 14px !important; font-weight: 500; margin-bottom: 15px !important }
        .fildname2 { width: 100% !important; height: 70px !important; font-size: 14px !important; font-weight: 500 !important; border: 1px solid #c7c7c7 !important }
        .c-lable { width: 250px; float: left }
        #missing-cb-tabpan h3 { font-size: 18px !important; padding: 13px 0 !important }
        .nav-pills .nav-link.active, .nav-pills .show > .nav-link { color: #fff; background: #ff3131 }
        .nav-pills > li > a { border-radius: 4px; color: #000 }
        .nav-pills > li > a:hover { text-decoration: none; background: #ff3131 }
        .nav-pills .nav-link { border-radius: .25rem; font-weight: 700 }
        .col-sm-3 { -ms-flex: 0 0 25%; flex: 0 0 25% }
        .nav-link { display: block; padding: .5rem 1rem; color: #000 }
        .flex-column { margin-top: 30px }
        .v-card { border: 1px solid #dee2e6 !important; padding: 10px 20px; border-radius: 6px; margin-top: 10px }
        .float-right { float: right !important }
        .float-right h4 { font-size: 22px !important; margin: 0 }
        #v-pills-tabContent { margin-top: 20px }
        .user-pro-info { padding: 10px }
        .user-earning-details { padding: 10px }
        .my-auto { width: 70% !important }
        .pagination { float: right }
        .table { margin-top: 20px }
        .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus { background-color: #ff3432 !important; border-color: #ff3432 !important; color: #fff !important }
        .pagination > li > a, .pagination > li > span { font-weight: 700 !important; font-size: 14px !important; color: #000 !important }
        .text-muted { font-size: 24px; color: #000 !important; padding: 10px 0 }
        .user-pro-pic { margin-top: -20px; text-align: center }
        .user-pro-pic img { width: 70px !important; border-radius: 50% }
        ul.list-inline { margin-bottom: 10px }
        .list-inline li { font-size: 14px; line-height: 24px }
        .cashback { width: auto !important }
        .nav-pills .nav-link { font-size: 15px !important }
        .v-card-title { width: 140px }
        h4 { clear: none }
        .float-right h4 { font-size: 16px !important }
        .v-card-title h4 { font-size: 16px !important; padding-top: 10px !important }
        .v-card i { font-size: 20px; color: #ff3a34 !important }
        .v-card { padding: 5px 10px !important }
        h4, .h4 { padding-top: 10px !important }
        .table th { padding: 5px !important; font-size: 12px !important }
        .avail-bal-info { border-top: 1px solid #bbb; margin-top: 15px; border-bottom: 1px solid #bbb }
        .text-muted { font-size: 20px !important }
        .listwith li { text-align: left !important; font-size: 15px !important }
        .tab-content { background: none !important }
        .p-info-wrapp strong { padding: 30px 0 10px !important }
        .hmb-5 { font-size: 16px !important; padding-top: 20px }
        .my-auto { width: 100% !important }
        .border-bottom { width: 100% !important; padding: 10px !important; font-size: 15px }
        .c-lable span strong { font-size: 15px !important }
        .c-lable-data span { font-size: 15px !important }
        .rounded { clear: both; float: none !important }
        .btn-primary { color: #fff; background: #FF3432; border-color: #FF3432; float: left; height: 34px; border: none; line-height: 34px; margin-right: 5px; padding: 0 5px; border-radius: 4px; font-weight: 700; font-size: 13px }
        .text-muted strong { font-size: 18px !important; color: #000 !important; padding: 20px 0 !important; display: block !important }
        .font-weight-bold { font-size: 16px !important; padding: 5px 0 !important }
        .msg-date { font-size: 16px !important; padding: 5px 0 !important }
        .vendor .data { text-align: center; padding: 15px }
        .thumbnail:hover { box-shadow: inset 0 0 17px 1px rgba(54, 71, 92, 0.30) }
        .thumbnail.vendor { width: 245px; margin-bottom: 0; text-align: center; border: none !important; min-height: 140px }
        .trendingdealsprobox { margin-top: 0 }
        .cs_dkt_si .next, .cs_dkt_si .prev { top: 25% }
        .vendors li { width: 245px }
        .vimg { position: relative; width: 100%; height: 100px; align-items: center; display: flex !important; text-align: center; line-height: 100px; -webkit-box-align: center; overflow: hidden; justify-content: center }
        .cshcoupons { max-width: 150px !important; max-height: 80px !important }
        .vcb { background: #fdfdfd; padding: 2px 20px !important; height: auto; margin-bottom: 20px; letter-spacing: 2px; border: 1px dashed #b5b5b5 }
        .call_to_action { margin-bottom: 20px }
        .popup2width { width: 700px !important; }
    </style>
    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>
    <div class="container">
        <section class="user-dash-wrap py-5">
            @include('v3.cashback.include.user-info')
            @include('v3.cashback.include.vendors')
            <div class="dash-navigation cashback rounded p-3">
                @if($errors->count())
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                <p>Error: </p>
                                @foreach( $errors->getMessages() as $msg )
                                    <p> {!! $msg[0] !!} </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                @if(session()->has('message'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success" role="alert">
                                <p>Success: </p>
                                <p> {!! session()->get('message') !!} </p>
                            </div>
                        </div>
                    </div>
                @endif
                @include('v3.cashback.include.actions')
                <div style="clear:both;"></div>
                @yield('cashback_section')
            </div>
        </section>
    </div>
    @if (!request()->hasCookie('first_cb_login'))
        <div class="modal fade bs-example-modal-lg" id="exit_popup_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div id="poup_content">
                    <div class="modal-content popup2width">
                        <button type="button" class="close popupright2" data-dismiss="modal" aria-label="Close" id="close_modal">
                            <span aria-hidden="true">×</span></button>
                        <div class="productdetailspopup mtop0">
                            <img src="{{asset('assets/v3/images')}}/cb_steps.jpg" alt="Register and Activate Cashback" style="width:100%"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <link rel="stylesheet" href="{{asset('assets/v3/fonts')}}/font-awesome.min.css"/>
    <script>
        var token = '{{csrf_token()}}';
        afterJquery(function () {
            $(document).on('click', '#v-pills-tab a.nav-link', function () {
                $("#v-pills-tab a.nav-link").removeClass('active');
                $(this).addClass('active');
            });
        });
        function confirmAction(action, params) {
            if (confirm('Are you sure.. ?')) {
                window.location.href = "?" + action + "&" + jQuery.param(params);
            }
        }

        function bootstrapLoaded() {
            @if (!request()->hasCookie('first_cb_login'))
            $("#exit_popup_modal").modal('show');
            setCookie('first_cb_login', 'yes', 30);
            @endif
        }

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/;";
        }

        afterJquery(function () {
            $(".moreproduct").on('click', function () {
                var wrapper = $(this).closest('.more_content_wrapper');
                var element = wrapper.find('.more-less-product1');

                if (element.hasClass('show')) {
                    element.removeClass('show');

                    $(this).html("Read More <span>&rsaquo;</span>");

                    $('html, body').animate({
                        scrollTop: wrapper.offset().top - $('header').height()
                    }, 200);
                }
                else {
                    element.addClass('show');
                    $(this).html("Show Less <span>&rsaquo;</span>");
                }
            });
        });
    </script>
    @yield('section_scripts')
@endsection