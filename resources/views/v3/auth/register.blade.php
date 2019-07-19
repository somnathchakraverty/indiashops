@extends('v3.master')
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                        <li><a>Home</a> >> <a href="#">Register</a></li>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('page_content')
    <div class="container">     
            <div class="col-md-7">
                <div class="sub-title">
                <h1>CashBack Registration</h1>
                </div>
                <div class="modal-content registration padding20">

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
                    <div class="cshbcktext">Register to claim the Cashback Offer</div>                    
                        <form method="post">
                            <div class="form-group float_left">
                                <label>Email / Username<span>*</span></label>
                                <input type="text" class="form-control" placeholder="Email / Username" name="email">
                            </div>
                            <div class="form-group float_left">
                                <label>Password<span>*</span></label>
                                <input type="password" class="form-control" placeholder="Password" name="password">
                            </div>

                            <div class="form-group float_left">
                                <label>Name<span>*</span></label>
                                <input type="text" class="form-control" placeholder="Name" name="name">
                            </div>
                            <div class="form-group float_left">
                                <label>Mobile</label>
                                <input type="text" class="form-control" placeholder="Mobile" name="mobile" value="{{old('mobile')}}">
                            </div>
                            <div class="form-group float_left">
                                <label>Gender</label>
                                <div class="genderradio">
                                    <input type="radio" value="male" name="gender" id="male" checked/>
                                    <label for="male"><span></span>Male</label>
                                    <input type="radio" value="female" name="gender" id="female"/>
                                    <label for="female"><span></span>Female</label>
                                </div>
                            </div>
                            <div class="form-group float_left">
                                <label>User Type</label>
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
                            <div {!! (old('user_type') != 'corporate') ? 'style="display: none"' : '' !!} id="corporate_details">
                                <div class="form-group float_left">
                                    <label>Company Name<span>*</span></label>
                                    <input type="text" class="form-control" placeholder="Company Name" name="company_name" value="{{old('company_name')}}">
                                </div>
                                <div class="form-group float_left">
                                    <label>GST</label>
                                    <input type="text" class="form-control" placeholder="GST (optional)" name="gst" value="{{old('gst')}}">
                                </div>
                                <div class="form-group float_left">
                                    <label>Address<span>*</span></label>
                                    <input type="text" class="form-control" placeholder="Address" name="address" value="{{old('address')}}">
                                </div>
                            </div>
                            <div class="form-group float_left" {!! (empty(old('referral_code'))) ? 'style="display: none"' : '' !!} id="referral">
                                <label>Referral Code:</label>
                                <input type="text" class="form-control" placeholder="Referral Code (Optional)" name="referral_code" value="{{old('referral_code')}}">
                            </div>
                            <div class="form-group" style="clear:both;">
                                <label>Interested In Categories:</label>
                                <select multiple="" class="form-control scrolbar" style="height: 92px;" name="interests">
                                    @foreach( $cats as $c )
                                        <option value="{{$c->id}}">{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="buttonclear">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button type="submit" class="btn btn-default registrationsubmit top-bg">Active CashBack</button>
                            @if(request()->has('redirect_url'))
                                <?php $login = route('login_v2', ['redirect_url' => request()->redirect_url]) ?>
                            @else
                                <?php $login = route('login_v2') ?>
                            @endif
                            <a href="{{$login}}" class="btn btn-default btn-info top-bg">Already have an
                                Account !</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
            <img class="cbk_regin img-responsive" src="/assets/v3/images/cashback_registration.png" alt="Cashback Registration">
                <!--<div class="sub-title">Top Mobile Brands in India</div>
                <ul class="product-list">
                    @foreach($brand_names as $brand)
                        <li>
                            <div class="pull-left MT0">
                                <a href="{{$brand->link}}" target="_blank">
                                    <img class="logoname_mlc" alt="{{$brand->alt}}" src="{{$brand->image_url}}"/>
                                </a>
                            </div>
                            <aside class="PT15 logonametext">
                                <a href="{{$brand->link}}" target="_blank">{{$brand->brand}}</a>
                            </aside>
                        </li>
                    @endforeach
                </ul>-->
            </div>        
    </div>
@endsection
@section('scripts')
    <script>
        function loadRestJS() {
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
<style>
h1{padding-bottom:0px; text-align:center;}
.float_left{float:left;width:47.5%;margin:7px 7px;}
.genderradio{margin-top:0px!important;}
.buttonclear{clear:both;margin-top:10px;display:inline-block;width:100%;}
.registration{top:2px!important;overflow:hidden;background:url(../assets/v3/images/reg_bg_co.jpg) top center;}
.registration label{color:#1d1d1d!important;}
.referral{color:#ff0000!important;text-decoration:none;}
.cshbcktext{color:#ff734b;margin-bottom:20px;font-size:18px;text-transform:uppercase;line-height:18px;font-weight:bold;text-align:center;overflow:hidden;border-radius:5px 0px;padding:10px;}
.product-list li{float:left; padding:5px;}
.product-list li a {line-height:40px;}
aside{text-align:center;}
.registrationsubmit{background:linear-gradient(to left,#00c53c,#0a8a00)!important;font-size:15px;color:#fff!important;border:none;font-weight:bold;padding:6px 40px!important;}
.cbk_regin{margin-top:50px; padding:0px; text-align:center; display:block;}
</style>
@endsection