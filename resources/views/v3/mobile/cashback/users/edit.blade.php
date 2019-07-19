@extends('v3.mobile.layout.cashback')
@section('cashback_section')
    <style type="text/css">
        .missing-cb-title h2 { font-size: 30px; color: #000; padding: 15px 0 }
        .missing-cb-title p { font-size: 15px; text-align: center; color: #000 }
        .bgcolor { background: #eaeaea; border-radius: 10px; margin-top: 30px; padding: 0 10px 20px }
        .fildname { border-radius: 5px !important; height: 40px !important; font-size: 15px !important; font-weight: 700; margin-bottom: 15px !important }
        .fildname2 { height: 70px !important }        
        .E-gift-wallet-form { margin-top: 20px !important }
        label { font-size: 14px; font-weight: 700 !important }
        small { font-size: 14px; font-weight: 700 !important }
        .btn-outline-primary { color: #fff !important; background: #ff3131 !important; margin: 10px 15px 0px 0px !important; }
        .font-weight-bold { font-weight: 700 !important; padding-top: 20px }
        .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control { background-color: #fff !important; opacity: 1 }
        .p-info-wrapp strong { font-size: 20px; padding: 30px 0 20px 14px; float: left; width: 100% }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="p-info-wrapp border rounded p-3">
                <strong>Update User</strong>
                <form method="post">
                    <div class="form-row">
                        <div class="col-sm-3">
                            <div class="form-label-group">
                                <label for="f-name">Name</label>
                                <input type="text" id="f-name" name="name" value="{{$user->name}}" class="form-control fildname" placeholder="Name" required="">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control fildname" disabled value="{{$user->email}}" id="email" name="email" placeholder="Email" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control fildname2" id="gender" name="gender" required>
                                    <option value="male">
                                        Male
                                    </option>
                                    <option value="female" {{($user->gender == 'female') ? 'selected' : ''}}>
                                        Female
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-label-group">
                                <label for="mob-num">Mobile Number</label>
                                <input type="text" id="mob-num" value="{{$user->mobile}}" name="mobile" class="form-control fildname" placeholder="Mobile Number" required="">
                            </div>
                        </div>
                        @if(!$user->isAdmin())
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="permissions">Permissions</label>
                                    @foreach(\indiashopps\Models\UserMapping::PERMISSIONS as $permission => $text)
                                        <div class="checkbox brand">
                                        <span class="attr_group">
                                            <input type="checkbox" id="chk{{clean($text)}}" name="permissions[]"
                                                   {{(in_array($permission,$permissions)) ? 'checked' : ''}}
                                                   value="{{$permission}}">
                                            <label for="chk{{clean($text)}}" class="attr_group_val">
                                                <span></span>{{$text}}
                                            </label>
                                        </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="text-right">
                        {{csrf_field()}}
                        <input type="hidden" name="action" value="update_user"/>
                        <button type="submit" class="btn btn-outline-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection