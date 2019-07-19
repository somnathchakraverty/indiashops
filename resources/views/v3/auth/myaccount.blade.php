@extends('v3.master')
<style>
    .facebook { background: #3b5998; border-radius: 5px; font-size: 16px; font-weight: 700; width: 40%; display: inline-block; text-align: center; float: left; margin-right: 20px }
    .google { background: #dd4b39; border-radius: 5px; font-size: 16px; font-weight: 700; width: 40%; display: inline-block; text-align: center }
    .btn { color: #fff; padding: 10px }
    .modal-dialog { width: 100%; margin: auto; margin-top: 30px; }
    .modal-title { text-align: center !important; font-size: 16px !important; font-weight: 700 !important }
    .loginfbg { width: 90%; margin: 15px auto }
    .modal-content { position: relative; background:url(../assets/v3/images/reg_bg_co.jpg) top center; -webkit-background-clip: padding-box; background-clip: padding-box; border: 1px solid #999; border: 1px solid rgba(0, 0, 0, .2); border-radius: 6px; outline: 0; -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, .5); box-shadow: 0 3px 9px rgba(0, 0, 0, .5) }
    .well { min-height: 20px; padding: 19px; width: 80%; margin: 20px auto; overflow: hidden; background-color: #f5f5f5; border: 1px solid #e3e3e3; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05) }
    label { display: inline-block; max-width: 100%; font-size: 15px; font-weight: 700 }
    .loginidtext { font-size: 13px; color: #000; font-weight: 500; height: 36px; margin-bottom: 10px; padding: 0px 10px; width: 100%; border-radius: 5px; border: 1px solid #bbb; outline: none; }
    .btn-success { color: #fff; background-color: #449d44; border-color: #398439; width: 45%; float: left; border: none; font-size: 16px; font-weight: 700; padding: 12px 0; border-radius: 5px }
    .rebtn-info { color: #fff; background-color: #5bc0de; border-color: #46b8da; float: right; font-weight: 700; margin-top: 0px; border-radius: 5px }
    #myModalLabel b { text-transform: uppercase; }
    .padding20 { padding: 20px; }
    .sub-title { font-size: 22px; font-weight: 700; text-align: left; color: #1f2228; padding: 0; margin: 15px 0px; }
    .rlist { width: 100%; border: 1px solid #c7c7c7; padding: 5px; margin-bottom: 15px; outline: none; }
    .registration label span { color: #ff0000; }
    .registrationsubmit{background-image:linear-gradient(to left, #ff774c, #ff3131) !important; color: #fff !important; border: none; font-size: 16px; border-radius: 5px; font-weight: bold; padding: 12px 15px; }
    .alert p { text-align: left; font-size: 13px; color: #ff0000; }
</style>
@section('page_content')
    <div class="wrapper">
        <!-- ========================================== about us ========================================= -->
        <div class="container"> {!! Breadcrumbs::render() !!}
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="modal-content registration padding20">
                    <h4 class="modal-title" id="myModalLabel"><b style="font-weight:bold;">My Account</b></h4>
                    <?php if( $errors->count() ):
                    $messages = $errors->getMessages(); ?>
                    <div class="alert alert-danger" role="alert">
                        <p>Error: </p>
                        <?php foreach( $messages as $msg ): ?>
                        <p>
                            <?=$msg[0]?>
                        </p>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    @if( !empty($success) )
                        <div class="alert alert-success" role="alert">
                            <p>Success: </p>
                            @foreach( $success as $msg )
                                <p>
                                    {{$msg}}
                                </p>
                            @endforeach
                        </div>
                    @endif
                    @if( \Session::has('status') )
                        <div class="alert alert-success" role="alert" style="padding: 0 20px">
                            <p>Success: </p>
                            <p>{{\Session::get('status')}}</p>
                        </div>
                    @endif
                    <form id="contact-form" method="post" action="" class="form-horizontal contact-form cf-style-1 inner-top-xs">
                        <input type="hidden" value="{{csrf_token()}}" name="_token">
                        <!-- Name input-->
                        <div id="contact-sm-6" style="padding-top:10px;">
                            <label for="username">Username<span>*</span></label>
                            <input type="email" class="form-control" disabled name="email" id="username" value="{{$user->email}}">
                        </div>
                        <div id="contact-sm-6" style="padding-top:10px;">
                            <label for="passwd">Password<span>*</span></label>
                            <input type="password" class="form-control" name="password" id="passwd">
                        </div>
                        <div id="contact-sm-6" style="padding-top:10px;">
                            <label for="name">Name<span>*</span></label>
                            <input type="text" class="form-control" placeholder="Name *" name="name" id="name" required value="{{$user->name}}">
                        </div>
                        <div class="contact-sm-6" style="padding-top:10px;">
                            <label>Mobile</label>
                            <input type="text" class="form-control" placeholder="Mobile" name="mobile" value="{{$user->mobile}}">
                        </div>
                        <div id="contact-sm-6" style="padding-top:10px;">
                            <label for="male">Gender</label>
                            <div class="genderradio">
                                <input type="radio" name="gender" value="male" id="male" <?=($user->gender == "male") ? "checked" : ""?>>
                                <label for='male'><span></span>Male</label>
                                <input type="radio" name="gender" value="female" id="female" <?=($user->gender == "female") ? "checked" : ""?>>
                                <label for='female'><span></span>Female</label>
                            </div>
                        </div>
                        @if($user->isAdmin())
                            <div id="corporate_details">
                                <div id="contact-sm-6" style="padding-top:10px;">
                                    <div class="">
                                        <label>Company Name<span>*</span></label>
                                        <input type="text" class="form-control" placeholder="Company Name" name="company_name" value="{{$user->company->company_name}}">
                                    </div>
                                </div>
                                <div id="contact-sm-6" style="padding-top:10px;">
                                    <div class="">
                                        <label>GST</label>
                                        <input type="text" class="form-control" placeholder="GST (optional)" name="gst" value="{{$user->company->gst}}">
                                    </div>
                                </div>
                                <div id="contact-sm-6" style="padding-top:10px;">
                                    <div class="">
                                        <label>Address<span>*</span></label>
                                        <input type="text" class="form-control" placeholder="Address" name="address" value="{{$user->company->address}}">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div id="contact-sm-6" style="padding-top:10px;">
                            <label for="interests" style="float:left;">Interest</label>
                            <span style="float:left;clear:both;padding:8px 0px;">Please let us know your Interest to get relevant Offers...</span>
                            <?php
                            $interest = json_decode($user->interests);
                            $interest = (is_array($interest)) ? $interest : array();
                            ?>
                            <select multiple="" class="form-control scrolbar" name="interests[]" id="interests" style="height: 100px;">
                                @foreach( $cats as $cat )
                                <option value="<?=$cat->id?>" <?=(in_array($cat->id, $interest)) ? "selected" : ""?> >
                                    {{$cat->name}}
                                </option>
                                @endforeach
                            </select>
                            <span style="float:left;clear:both;padding:8px 0px 15px 0px;">Press Ctrl to select Multiple options</span>
                        </div>
                        <!-- Form actions -->
                        <div class="form-group" style="clear:both;margin-top:20px;">
                            <div class="text-center">
                                <div class="buttons-holder">
                                    <input type="hidden" name="user_type" value="{{($user->company_id != 0) ? 'corporate' : 'individual'}}"/>
                                    <button class="btn registrationsubmit" type="submit" style="font-size:15px;padding:7px 20px!important;">Update</button>
                                    <a class="btn registrationsubmit" href="{{route('logout')}}" style="font-size:15px;padding:7px 20px!important;">Logout</a>
                                </div>
                                <!-- /.buttons-holder -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="col-md-3"></div>
    </div>
    <!-- ========================================= about end : END ========================================= -->
@endsection