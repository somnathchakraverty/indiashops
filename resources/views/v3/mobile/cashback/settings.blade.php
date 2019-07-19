@extends('v3.mobile.layout.cashback')
@section('cashback_section')
    <style type="text/css">
        .missing-cb-title h2{font-size:30px;color:#000;padding:15px 0}
		.missing-cb-title p{font-size:15px;text-align:center;color:#000}
		.bgcolor{background:#eaeaea;border-radius:10px;margin-top:30px;padding:0 10px 20px}
		.E-gift-wallet-form{margin-top:20px!important}
		label{font-size:14px;font-weight:700!important}
		small{font-size:14px;font-weight:700!important}		
		.font-weight-bold{font-weight:700!important;padding-top:20px}
		.form-control[disabled],.form-control[readonly],fieldset[disabled] .form-control{background-color:#fff!important;opacity:1}
		.p-info-wrapp strong{font-size:20px;padding-bottom:20px;float:left;width:100%}
    </style>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane active" id="profile-setting-tabpan" role="tabpanel">
          
               
                    <ul class="tabs nav-pills">
                    <li class="tab">
                        <a class="nav-link {{(session()->get('action') != 'password') ? 'active' : ''}}" href="#p-setting">
                            Personal Information
                        </a>
                        </li>
                        <li class="tab">
                            <a class="nav-link {{(session()->get('action') == 'password') ? 'active' : ''}}" href="#ch-pass">
                                Change Password
                            </a>
                        </li>
                    </ul>
               
               
                    <div class="tab-content" id="p-setting-tabContent">
                        <div class="tab-pane {{(session()->get('action') != 'password') ? 'in active' : ''}}" id="p-setting" role="tabpanel" aria-labelledby="p-setting-tab">
                            <div class="p-info-wrapp border rounded p-3">
                                <strong>Edit personal info</strong>
                                <form method="post">
                                    <div class="form-row">
                                       
                                            <div class="form-label-group">
                                                <label for="f-name">Name</label>
                                                <input type="text" id="f-name" name="name" class="form-control fildname" placeholder="Name" required="" value="{{$user->name}}">
                                            </div>
                                     
                                       
                                            <div class="form-label-group">
                                                <label for="datepicker">Date Of Birth</label>
                                                <input type="date" id="datepicker" name="date_of_birth" class="form-control fildname" placeholder="Date Of Birth" value="{{$user->bday}}" required>
                                            </div>
                                       
                                       
                                            <div class="form-group">
                                                <label for="mob-num">Email</label>
                                                <input class="form-control fildname" name="email" type="text" value="{{$user->email}}" disabled>
                                            </div>
                                      
                                       
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select class="form-control fildname" id="gender" name="gender">
                                                    <option value="">Select Your Gender</option>
                                                    <option value="male" {{($user->gender == 'male') ? 'selected' : ''}}>
                                                        Male
                                                    </option>
                                                    <option value="female" {{($user->gender == 'female') ? 'selected' : ''}}>
                                                        Female
                                                    </option>
                                                </select>
                                            </div>
                                        
                                       
                                            <div class="form-label-group">
                                                <label for="country">Country</label>
                                                <input type="text" id="country" name="country" class="form-control fildname" value="{{$user->country}}" placeholder="Country" required="">
                                            </div>
                                      
                                      
                                            <div class="form-label-group">
                                                <label for="city">City</label>
                                                <input type="text" id="city" name="city" class="form-control fildname" value="{{$user->city}}" placeholder="City" required="" name="city">
                                            </div>
                                     
                                      
                                            <div class="form-label-group">
                                                <label for="mob-num">Mobile Number</label>
                                                <input type="text" id="mob-num" name="mobile" class="form-control fildname" value="{{$user->mobile}}" placeholder="Mobile Number" required="">
                                            </div>
                                     
                                    </div>
                                    <div class="text-right">
                                        {{csrf_field()}}
                                        <input type="hidden" name="user_id" value="{{$user->id}}"/>
                                        <input type="hidden" name="action" value="profile"/>
                                        <button type="submit" class="btn btn-outline-primary">SAVE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade {{(session()->get('action') == 'password') ? 'in active' : ''}}" id="ch-pass" role="tabpanel" aria-labelledby="ch-pass-tab">
                            <div class="p-info-wrapp c-password-wrapp border p-3">
                                <strong>Change Password</strong>
                                <form method="post">
                                    <div class="form-row">
                                       
                                            <div class="form-label-group">
                                                <label for="o-pass">Old Password</label>
                                                <input type="password" id="o-pass" name="old_password" class="form-control fildname" placeholder="Old Password" required="">
                                            </div>
                                      
                                      
                                            <div class="form-label-group">
                                                <label for="n-pass">New Password</label>
                                                <input type="password" id="n-pass" name="password" class="form-control fildname" placeholder="New Password" required="">
                                            </div>
                                     
                                       
                                            <div class="form-label-group">
                                                <label for="c-pass">Confirm Password</label>
                                                <input type="password" id="c-pass" name="password_confirmation" class="form-control fildname" placeholder="Confirm Password" required="">
                                            </div>
                                      
                                    </div>
                                    <div class="text-right">
                                        {{csrf_field()}}
                                        <input type="hidden" name="user_id" value="{{$user->id}}"/>
                                        <input type="hidden" name="action" value="password"/>
                                        <button type="submit" class="btn btn-outline-primary">SAVE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
               
           
        </div>
        @endsection
        @section('section_scripts')
            <script>

            </script>
@endsection