@extends('v3.mobile.master')
<style>
    h1{font-size:20px!important;}
	.registration{overflow:hidden;background: url(../assets/v3/mobile/images/register_bg.jpg) no-repeat top center;}
	.registration label{color:#000!important;}
	input[type=radio] + label{color:#fff!important;}
	.cshbcktext{background:#ff734b;color:#fff;margin-bottom:20px;font-size:15px;text-transform:uppercase;line-height:18px;font-weight:bold;text-align:center;overflow:hidden;border-radius:5px 0px;padding:5px 0px 3px 0px;}
	.referral{color:#ff0000;}
    .search-header { width: 100% !important; height: 45px !important; }
    .facebook { background: #3b5998; border-radius: 5px; font-size: 16px; font-weight: 700; width: 38%; display: inline-block; text-align: center; float: left; margin-right: 20px }
    .google { background: #dd4b39; border-radius: 5px; font-size: 16px; font-weight: 700; width: 38%; display: inline-block; text-align: center }
    .btn { color: #fff; padding: 10px }
    .modal-dialog { width: 100%; margin: auto; margin-top: 30px; }
    .modal-title { text-align: center !important; font-size: 16px !important; font-weight: 700 !important }
    .loginfbg { width: 90%; margin: 15px auto }
    .modal-content { position: relative; background:url(../assets/v3/images/reg_bg_co.jpg) top center; -webkit-background-clip: padding-box; background-clip: padding-box; border: 1px solid #999; border: 1px solid rgba(0, 0, 0, .2); border-radius: 6px; outline: 0; -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, .5); box-shadow: 0 3px 9px rgba(0, 0, 0, .5) }
    .well { min-height: 20px; padding: 19px; width: 80%; margin: 20px auto; overflow: hidden; background-color: #f5f5f5; border: 1px solid #e3e3e3; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05) }
    label { display: inline-block; max-width: 100%; font-size: 15px; font-weight: 700 }
    .loginidtext { font-size: 13px; color: #000; font-weight: 500; height: 42px; margin-bottom: 10px; padding: 0px 10px; width: 100%; border-radius: 5px; border: 1px solid #bbb; outline: none; }
    .btn-success { color: #fff; background-color: #449d44; border-color: #398439; width: 45%; float: left; border: none; font-size: 16px; font-weight: 700; padding: 12px 0; border-radius: 5px }
    .rebtn-info { color: #fff; background-color: #5bc0de; border-color: #46b8da; font-size:14px; float: right; font-weight: 700; margin-top: 0px; border-radius: 5px }
    #myModalLabel b { text-transform: uppercase; }
    .padding20 { padding: 20px; }
    .sub-title { font-size: 22px; font-weight: 700; text-align: left; color: #1f2228; padding: 0; margin: 15px 0px; }
    .rlist { width: 100%; border: 1px solid #c7c7c7; padding: 5px; margin-bottom: 15px; outline: none; }
    .registration label span { color: #ff0000; }
    .registrationsubmit{background-image:linear-gradient(to left, #ff774c, #ff3131)!important;color:#fff!important;border:none;font-size:14px;border-radius:5px;font-weight:bold;padding:12px 15px;}
    .alert p{text-align:left;font-size:13px;color:#ff0000;}
	.cbk_regin{text-align:center;margin:auto;display:block;}
	
</style>
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render("register") !!}
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-9 PL0">
                <div class="sub-title"><h1>CashBack Registration</h1></div>
                <div class="modal-content registration padding20">
                <div class="cshbcktext">Register to claim the Cashback Offer</div>
                    <?php if( $errors->count() ):
                    $messages = $errors->getMessages(); ?>

                    <div class="alert alert-danger" role="alert">
                        <p>Error: </p>
                        <?php foreach( $messages as $msg ): ?>
                        <p> <?=$msg[0]?> </p>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="shadow-box">
                        <form method="post">
                            <div class="form-group">
                                <label>Email / Username<span>*</span></label>
                                <input type="text" class="form-control loginidtext" placeholder="Email / Username" name="email" value="{{old('email')}}">
                            </div>
                            <div class="form-group">
                                <label>Password<span>*</span></label>
                                <input type="password" class="form-control loginidtext" placeholder="Password" name="password">
                            </div>

                            <div class="form-group">
                                <label>Name<span>*</span></label>
                                <input type="text" class="form-control loginidtext" placeholder="Name" name="name" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" class="form-control loginidtext" placeholder="Mobile" name="mobile" value="{{old('mobile')}}">
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="genderradio">
                                    <input type="radio" value="male" name="gender" id="male" checked/>
                                    <label for="male"><span></span>Male</label>
                                    <input type="radio" value="female" name="gender" id="female"/>
                                    <label for="female"><span></span>Female</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>User Type<span>*</span></label>
                                <div class="genderradio">
                                    <input type="radio" class="user_type" value="individual" name="user_type" id="individual" {{(old('user_type') != 'corporate') ? 'checked' : ''}}/>
                                    <label for="individual"><span></span>Individual</label>
                                    <input type="radio" class="user_type" value="corporate" name="user_type" id="corporate" {{(old('user_type') == 'corporate') ? 'checked' : ''}}/>
                                    <label for="corporate"><span></span>Corporate</label>
                                    <label for="referral">
                                        <a class="referral" href="javascript:void(0)" id="have_referral">Have Referral Code ?</a>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" {!! (empty(old('referral_code'))) ? 'style="display: none"' : '' !!} id="referral">
                                <label>Referral Code:</label>
                                <input type="text" class="form-control loginidtext" placeholder="Referral Code (Optional)" name="referral_code" value="{{old('referral_code')}}">
                            </div>
                            <div {!! (old('user_type') != 'corporate') ? 'style="display: none"' : '' !!} id="corporate_details">
                                <div class="form-group">
                                    <label>Company Name<span>*</span></label>
                                    <input type="text" class="form-control loginidtext" placeholder="Company Name" name="company_name" value="{{old('company_name')}}">
                                </div>
                                <div class="form-group">
                                    <label>GST</label>
                                    <input type="text" class="form-control loginidtext" placeholder="GST (optional)" name="gst" value="{{old('gst')}}">
                                </div>
                                <div class="form-group">
                                    <label>Address<span>*</span></label>
                                    <input type="text" class="form-control loginidtext" placeholder="Address" name="address" value="{{old('address')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Interested In Categories:</label>
                                <select multiple="" class="form-control rlist" style="height:65px;" name="interests">
                                    @foreach( $cats as $c )
                                        <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button type="submit" class="btn btn-default registrationsubmit top-bg">SUBMIT</button>
                            <a href="{{route('login_v2')}}" class="btn btn-default rebtn-info top-bg">Already Have An
                                Account !</a>
                        </form>
                    </div>
                    <img class="cbk_regin" src="/assets/v3/mobile/images/cab_regsn.png" alt="Cashback Registration">
                </div>
                
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{get_file_url('mobile/js/front.js')}}" defer></script>
    <script>
        function loadCarousels() {}
        function uiLoaded() {}
        function MLoaded() {
            $(document).on('change', '.user_type', function () {
                if ($('input[name="user_type"]:checked').val() == 'corporate') {
                    $("#corporate_details").slideDown();
                }
                else {
                    $("#corporate_details").slideUp();
                }
            });
            $(document).on('click', '#have_referral', function () {
                $("#referral").slideToggle();
            });
        }
    </script>
@endsection