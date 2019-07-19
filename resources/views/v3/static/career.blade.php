@extends('v3.master')
@section('page_content')
    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>
    <div class="container">
        <div class="sub-title mtop2">Creating Revolution</div>
        <div class="col-md-7 pleft">
            <div class="modal-content aboutus padding20">
                <p>The world is changing, as is the internet. You can either experience changes, or be the change.</p>
                <p>We are on the road to revolutionize online shopping - and become the hub for e-commerce in India -
                    which is the hottest sector as of today. We are young, driven, and different. We are different and
                    we think different. Our plans are not limited to the confines of a city or a college - but span the
                    whole nation and the most booming sector - e commerce. We are on a mission to give the ultimate
                    shopping experience to our user. In the process we defy ordinary thinking to achieve it.</p>
                <p>So you think you could think outside the box? Well, we live outside the box.</p>
                <p>Think you have what it takes? Come join us!</p>
                <p><span style="color:#ff3834;font-weight:bold;">Send in your CV to hr@indiashopps.com</span> and stand
                    a chance to be a part of the revolution.</p>
                <div class="oppingjob">
                    <h3>CURRENT OPENINGS</h3>
                    <ul>
                        <li>Software Developer (PHP)</li>
                        <li>Content Writer</li>
                        <li>Front-End Developer</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <img class="img-responsive" src="{{asset('assets/v2/')}}/images/career.jpg" alt="About Indiashopps"/>
        </div>
    </div>

@endsection