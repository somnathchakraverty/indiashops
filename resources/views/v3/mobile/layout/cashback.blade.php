@extends($layout_file)
@section('page_content')
    <style type="text/css">
        .linkbg{width:100%;background:#fff;margin-top:0!important;padding-top:15px!important;clear:both;display:inline-block;border-radius:4px;box-shadow:0 1px 3px 0 rgba(0,0,0,0.1)}
		.cashback{width:100%;margin:10px 0 40px;padding:10px;border-radius:4px;background-color:#fff;box-shadow:0 1px 3px 0 rgba(0,0,0,0.1);overflow:hidden}
		.v-card-title{display:inline-block;width:50%}
		.v-card-title h4{margin-top:0}
		.v-card i{font-size:30px;float:left;margin:0 10px 0 0;color:#ff3a34}
		.user-pro-pic{margin:10px 0 0 15px !important}
		.user-pro-pic img{width:125px;border-radius:50%}
		.c-lable{width:250px;float:left}
		#missing-cb-tabpan h3{font-size:16px!important;padding:13px 0!important}
		.nav-pills{width:100%;border-bottom:1px solid #bbb;margin:20px 0px;display:inline-block;}
		.nav-pills .nav-link.active{color:#0fc9da;border-bottom:4px solid #0fc9da;}
		.nav-link{display:inline-block;padding:7px;color:#000;font-size:12.5px;font-weight:700;}		
		.flex-column{margin-top:20px;background:#eaeaea;border-radius:4px}
		.v-card{border:1px solid #dee2e6!important;padding:10px 20px;border-radius:6px;margin-top:10px}
		.float-right{float:right!important}
		.float-right h4{font-size:22px!important;margin:0}
		.user-pro-info{padding:10px}
		.user-earning-details{padding:10px}		
		.pagination{float:right}		
		.pagination > .active > a,.pagination > .active > span,.pagination > .active > a:hover,.pagination > .active > span:hover,.pagination > .active > a:focus,.pagination > .active > span:focus{background-color:#ff3432!important;border-color:#ff3432!important;color:#fff!important}
		.pagination > li > a,.pagination > li > span{font-weight:700!important;font-size:14px!important;color:#000!important}
		.text-muted{font-size:24px;color:#000!important;padding:10px 0}
		.dash-navigation #action_option{height:38px;border:1px solid #c7c7c7;background:#fff;border-radius:4px;font-size:14px;width:100%;margin:5px 0;color:#5a5a5a;padding-left:5px}
		.dash-navigation label{font-size:13px;font-weight:700}		
		.user-pro-pic{margin-top:-20px;text-align:center}
		.user-pro-pic img{width:70px!important}
		ul.list-inline{margin-bottom:10px}
		.list-inline li{font-size:14px;line-height:24px}
		.cashback{width:auto!important}		
		.v-card-title{width:140px}
		h4{clear:none}
		.float-right h4{font-size:16px!important}
		.v-card-title h4{font-size:16px!important;padding-top:10px!important}
		.v-card i{font-size:20px;color:#ff3a34!important}
		.v-card{padding:5px 10px!important}
		h4,.h4{padding-top:10px!important}
		.table th{padding:5px!important;font-size:12px!important}
		.avail-bal-info{border-top:1px solid #bbb;margin-top:15px;border-bottom:1px solid #bbb}
		.text-muted{font-size:20px!important}
		.listwith li{text-align:left!important;font-size:15px!important}
		.tab-content{background:none!important}		
		.hmb-5{font-size:16px!important;padding:10px 0px;}
		.my-auto{width:100%!important;padding:10px;}
		.border-bottom{font-size:14px}
		.c-lable span strong{font-size:14px!important}
		.c-lable-data span{font-size:14px!important}
		.rounded{clear:both;float:none!important}
		.btn-primary{color:#fff;background:#FF3432;border-color:#FF3432;float:left;height:34px;border:none;line-height:34px;margin-right:5px;padding:0 5px;border-radius:4px;font-weight:700;font-size:13px}
		.text-muted strong{font-size:18px!important;color:#000!important;padding:20px 0!important;display:block!important}
		.font-weight-bold{font-size:16px!important;padding:5px 0!important}
		.msg-date{font-size:16px!important;padding:5px 0!important}
		.table-responsive{clear:both;overflow-y:auto;}
		.btn-outline-primary{color:#fff!important;background:#ff3131!important;margin-top:10px!important;padding:7px 10px;font-weight:700;font-size:14px;display:inline-block;border-radius:4px;border:none;}
		.permissions{padding-top:10px!important;font-size:16px!important;}
		
    </style>
    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>
    <div class="container">
        <section class="user-dash-wrap py-5">
            @include('v3.mobile.cashback.include.user-info')
            <div class="dash-navigation cashback rounded p-3">
                @if($errors->count())
                    
                            <div class="alert alert-danger" role="alert">
                                <p>Error: </p>
                                @foreach( $errors->getMessages() as $msg )
                                    <p> {!! $msg[0] !!} </p>
                                @endforeach
                            </div>

                @endif
                @if(session()->has('message'))
                  
                       
                            <div class="alert alert-success" role="alert">
                                <p>Success: </p>
                                <p> {!! session()->get('message') !!} </p>
                            </div>
                       
                  
                @endif
                @include('v3.mobile.cashback.include.actions')
                <div style="clear:both;"></div>
                @yield('cashback_section')
            </div>
        </section>
    </div>
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

            $(document).on('change', '#action_option', function () {
                var option = $(this.options[this.selectedIndex]);
                var url = option.attr('data-url');

                if( typeof url != 'undefined')
                {
                    window.location.href = url;
                }
            });
        });
        function confirmAction(action, params) {
            if (confirm('Are you sure.. ?')) {
                window.location.href = "?" + action + "&" + jQuery.param(params);
            }
        }
    </script>
    @yield('section_scripts')
@endsection