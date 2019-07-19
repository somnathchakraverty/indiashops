@extends('v3.mobile.master')
<style>
    .oppingjob { margin-top: 20px; padding-top:15px; border-top: 1px solid #e4e4e4; }
    .oppingjob ul { display: block; margin: auto; text-align: center; padding: 0px; }
    .oppingjob ul li { background-image: linear-gradient(to left, #ff774c, #ff3131) !important; font-size: 14px; font-weight: bold; text-align: center; color: #fff; border: 1px solid # #e40046; padding: 10px; margin-bottom: 10px; display: inline-block; border-radius: 5px; }
</style>
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>
    <section>      
        <div class="whitecolorbg">
            <div class="container">
            <h1 style="margin:0px 0px 15px 0px;">Creating Revolution</h1>
                <p>The world is changing, as is the internet. You can either experience changes, or be the change.</p>
                <p>We are on the road to revolutionize online shopping - and become the hub for e-commerce in India -
                    which is the hottest sector as of today. We are young, driven, and different. We are different and
                    we think different. Our plans are not limited to the confines of a city or a college - but span the
                    whole nation and the most booming sector - e commerce. We are on a mission to give the ultimate
                    shopping experience to our user. In the process we defy ordinary thinking to achieve it.</p>
                <p>So you think you could think outside the box? Well, we live outside the box.</p>
                <p>Think you have what it takes? Come join us!</p>
                <p>
                    <span style="font-weight:bold;">Send in your CV to <a href="mailto:hr@indiashopps.com" style="color:#ff3834;font-weight:bold;">hr@indiashopps
                            .com</a></span> and stand
                    a chance to be a part of the revolution.</p>
                <div class="oppingjob">
                    <h3>CURRENT OPENINGS</h3>
                    <ul style="margin-top:15px;">
                        <li>Software Developer (PHP)</li>
                        <li>Content Writer</li>
                        <li>Front-End Developer</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="whitecolorbg" style="margin-top:20px;">
            <div class="container"><img class="img-responsive" src="{{asset('assets/v2/')}}/images/career.jpg"></div>
        </div>

    </section>
@endsection
@section('scripts')
	<script src="{{get_file_url('mobile/js/front.js')}}" defer></script>
    <script>
        function loadCarousels(){}
        function uiLoaded(){}
    </script>
@endsection