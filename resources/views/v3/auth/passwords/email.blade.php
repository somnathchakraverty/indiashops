@extends('v3.master')
@section('page_content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 PL0">
                <div id="login-overlay" class="modal-dialog">
                    <div class="modal-content loginpage">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Reset <b>Password</b></h4>
                            @if( $errors->count() )
                                <div class="alert alert-danger" role="alert">
                                    <p>Error: </p>
                                    @foreach( $errors->getMessages() as $msg )
                                        <p> {{$msg[0]}} </p>
                                    @endforeach
                                </div>
                            @endif
                            @if( \Session::has('status') )
                                <div class="alert alert-success" role="alert" style="padding: 0 20px">
                                    <p>Success: </p>
                                    <p>{{\Session::get('status')}}</p>
                                </div>
                            @endif
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="well">
                                        <form id="loginForm" method="post" action="{{route('password.send_reset')}}">
                                            <div class="form-group">
                                                <label for="username" class="control-label" style="font-weight:bold;">Email</label>
                                                <input type="email" class="form-control loginidtext" name="email" value="" required="" placeholder="Email" id="username">
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group">

                                            </div>
                                            <div id="loginErrorMsg" class="alert alert-error hide">Wrong username or
                                                password
                                            </div>
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <button type="submit" value="login" name="submit" class="btn btn-success btn-block">
                                                Send Reset Link
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <style>
        .btn.facebook { background: #3b5998; font-size: 17px; }
        .btn.google { background: #dd4b39; font-size: 17px; }
        .btn { color: #fff; padding: 10px; }
        .modal-dialog { top: 0px !important; }
        .cshbcktext { color: #ff714a; font-size: 15px; font-weight: bold; text-align: center; overflow: hidden; padding: 0px; text-transform: uppercase; }
    </style>
@endsection