@extends('v3.mobile.layout.cashback')
@section('cashback_section')
    <style type="text/css">
        .missing-cb-title h2 { font-size: 30px; color: #000; padding: 15px 0 }
        .missing-cb-title p { font-size: 15px; text-align: center; color: #000 }
        .bgcolor { background: #eaeaea; border-radius: 10px; margin-top: 30px; padding: 0 10px 20px }       
        .fildname2 { height: 70px !important }        
        .E-gift-wallet-form { margin-top: 20px !important }
        label { font-size: 14px; font-weight: 700 !important }
        small { font-size: 14px; font-weight: 700 !important }
        .btn-outline-primary { color: #fff !important; background: #ff3131 !important; margin: 10px 15px 0px 0px !important; }
        .font-weight-bold { font-weight: 700 !important; padding-top: 20px }
        .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control { background-color: #fff !important; opacity: 1 }
        .p-info-wrapp strong {font-size:16px;padding:15px 0px;float:left;width:100%}
		.checkbox{width:100%!important;margin:0px!important;}
		.checkbox label, .radio label{font-weight:500!important;}
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="p-info-wrapp border rounded p-3">
                <strong>New User</strong>
                <form method="post">
                    <div class="form-row">
                        <div class="col-sm-3">
                            <div class="form-label-group">
                                <label for="f-name">Name</label>
                                <input type="text" id="f-name" name="name" class="form-control fildname" placeholder="Name" required="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control fildname" id="email" name="email" placeholder="Email" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control fildname" id="gender" name="gender" required>
                                    <option value="">Select Your Gender</option>
                                    <option value="male">
                                        Male
                                    </option>
                                    <option value="female">
                                        Female
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-label-group">
                                <label for="mob-num">Mobile Number</label>
                                <input type="text" id="mob-num" name="mobile" class="form-control fildname" placeholder="Mobile Number" required="">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="permissions" for="permissions">Permissions</label>
                                @foreach(\indiashopps\Models\UserMapping::PERMISSIONS as $permission => $text)
                                    <div class="checkbox brand">
                                        <span class="attr_group">
                                            <input type="checkbox" id="chk{{clean($text)}}" name="permissions[]" value="{{$permission}}">
                                            <label for="chk{{clean($text)}}" class="attr_group_val">
                                                <span></span>{{$text}}
                                            </label>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        {{csrf_field()}}
                        <input type="hidden" name="action" value="new_user"/>
                        <button type="submit" class="btn btn-outline-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection