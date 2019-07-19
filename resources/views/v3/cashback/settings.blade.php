@extends('v3.layout.cashback')
@section('cashback_section')
    <style type="text/css">
        .missing-cb-title h2 { font-size: 30px; color: #000; padding: 15px 0 }
        .missing-cb-title p { font-size: 15px; text-align: center; color: #000 }
        .bgcolor { background: #eaeaea; border-radius: 10px; margin-top: 30px; padding: 0 10px 20px }    
        .E-gift-wallet-form { margin-top: 20px !important }
        label { font-size: 14px; font-weight: 700 !important }
        small { font-size: 14px; font-weight: 700 !important }
        .btn-outline-primary { color: #fff !important; background: #ff3131 !important; margin: 10px 15px 0px 0px !important; }
        .font-weight-bold { font-weight: 700 !important; padding-top: 20px }
        .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control { background-color: #fff !important; opacity: 1 }
        .p-info-wrapp strong { font-size: 20px; padding: 30px 0 20px 14px; float: left; width: 100% }
    </style>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane active" id="profile-setting-tabpan" role="tabpanel">
            <div class="row">
                <div class="col-sm-3 mb-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link {{(session()->get('action') != 'password') ? 'active' : ''}}" id="p-setting-tab" data-toggle="pill" href="#p-setting" role="tab" aria-controls="p-setting" aria-selected="true">Personal
                            Information</a>
                        <a class="nav-link {{(session()->get('action') == 'password') ? 'active' : ''}}" id="ch-pass-tab" data-toggle="pill" href="#ch-pass" role="tab" aria-controls="ch-pass" aria-selected="false">Change
                            Password</a>
                    </div>
                </div>
                <div class="col-sm-9 bgcolor">
                    <div class="tab-content" id="p-setting-tabContent">
                        <div class="tab-pane {{(session()->get('action') != 'password') ? 'in active' : ''}}" id="p-setting" role="tabpanel" aria-labelledby="p-setting-tab">
                            <div class="p-info-wrapp border rounded p-3">
                                <strong>Edit personal info</strong>
                                <form method="post">
                                    <div class="form-row">
                                        <div class="col-sm-4">
                                            <div class="form-label-group">
                                                <label for="f-name">Name</label>
                                                <input type="text" id="f-name" name="name" class="form-control fildname" placeholder="Name" required="" value="{{$user->name}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-label-group">
                                                <label for="datepicker">Date Of Birth</label>
                                                <input type="date" id="datepicker" name="date_of_birth" class="form-control fildname" placeholder="Date Of Birth" value="{{$user->bday}}" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="mob-num">Email</label>
                                                <input class="form-control fildname" name="email" type="text" value="{{$user->email}}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
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
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-label-group">
                                                <label for="country">Country</label>
                                                <input type="text" id="country" name="country" class="form-control fildname" value="{{$user->country}}" placeholder="Country" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-label-group">
                                                <label for="city">City</label>
                                                <input type="text" id="city" name="city" class="form-control fildname" value="{{$user->city}}" placeholder="City" required="" name="city">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-label-group">
                                                <label for="mob-num">Mobile Number</label>
                                                <input type="text" id="mob-num" name="mobile" class="form-control fildname" value="{{$user->mobile}}" placeholder="Mobile Number" required="">
                                            </div>
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
                                        <div class="col-sm-4">
                                            <div class="form-label-group">
                                                <label for="o-pass">Old Password</label>
                                                <input type="password" id="o-pass" name="old_password" class="form-control fildname" placeholder="Old Password" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-label-group">
                                                <label for="n-pass">New Password</label>
                                                <input type="password" id="n-pass" name="password" class="form-control fildname" placeholder="New Password" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-label-group">
                                                <label for="c-pass">Confirm Password</label>
                                                <input type="password" id="c-pass" name="password_confirmation" class="form-control fildname" placeholder="Confirm Password" required="">
                                            </div>
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
            </div>
        </div>
        @endsection
        @section('section_scripts')
            <script>

            </script>
@endsection