<div class="breadcrumb-bg">
    <div class="container">
        {!! Breadcrumbs::render("login") !!}
    </div>
</div>
<!--PART-1-->
<div class="signupbg">
    <div class="container">
        <div class="col-md-12 form-line">
            <div class="errors alert alert-danger" style="display: none"></div>
            <div class="success alert alert-success" style="display: none"></div>
        </div>
        <div class="main-login main-center">
            <!-- Nav tabs -->
            <img src="{{asset('assets/v2/images/loading.gif')}}" style="display:none" id="loadergif"/>
            <ul class="nav nav-tabs tabdesign bordernone" role="tablist">
                <li role="presentation" class="{{($route == 'login') ? 'active' : ''}}">
                    <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                        Sign In
                    </a>
                </li>
                <li role="presentation" class="{{($route == 'register') ? 'active' : ''}}">
                    <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
                        Sign Up
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content signintab">
                <div role="tabpanel" class="tab-pane {{($route == 'login') ? 'active' : ''}}" id="home">
                    <form class="form-horizontal" method="post" action="#" id="login_form">
                        <div class="signup">Sign In</div>
                        <div class="socialicon">
                            <a href="<?=newUrl('slogin/facebook')?>" title="Facebook" class="btn-facebook">
                                <img class="facebookiconimg"
                                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAQCAYAAAArij59AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjA1RjQ1RkQxQUI0OTExRTc5QTA1RDZCQUYyNDVEMjVBIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjA1RjQ1RkQyQUI0OTExRTc5QTA1RDZCQUYyNDVEMjVBIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDVGNDVGQ0ZBQjQ5MTFFNzlBMDVENkJBRjI0NUQyNUEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDVGNDVGRDBBQjQ5MTFFNzlBMDVENkJBRjI0NUQyNUEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4I2iLDAAAAoElEQVR42mL8//8/AxJgBuIwILYGYm4g/sAAUgDFrEC8/D8aQFYQhyb3DYhfsSAZ74rELgbidUD8D1kBGxJ7LxA/ADGYkASRXcsJpRkZgfa0AhmBQCwNxHxQCZDu70D8C2SFChBrMqACBRgDpOAWEF8CYjkgFoCK3wHib0D8HtmbK5C8aA4Tx+VIOEBWwIiNzcRAAJCkgJGQAmZsigECDABIJmsQvd6OCAAAAABJRU5ErkJggg==">
                                Facebook</a>
                            <a href="<?=newUrl('slogin/google')?>" title="Google+" class="btn-googleplus">
                                <img class="googleiconimg"
                                     src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAAAOCAYAAADJ7fe0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjE4QzRDNzIxQUI0OTExRTc5MTVFODcwNzAzNkFFQTEzIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjE4QzRDNzIyQUI0OTExRTc5MTVFODcwNzAzNkFFQTEzIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MThDNEM3MUZBQjQ5MTFFNzkxNUU4NzA3MDM2QUVBMTMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MThDNEM3MjBBQjQ5MTFFNzkxNUU4NzA3MDM2QUVBMTMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4tviAqAAABRklEQVR42oTSzyuEQRzH8UlbWmpLcnBzwCrcFDlR+wdIrri5cCAl5cTBQfEHOBHlzIFycFwSS5HDHlbRFm17oKzy6/GefJ6M8bTP1KvnmWdmPvM833lMEARGurCNO1RQlgdsoFXz5nHhrDPhzQCecIRhbAW/bdpdgEXc+yG1uNaCdmfwTM92UIdmWdPbhv1GOznt7NrthMzqWRZTeJNPfDn9g4Qx5hmvSGIIV+anlXQtYBd59ceQ0dW2crjrqnb9wLhqdIlbtHk1WUAhqrAJzOEc7wososkLsJZ1Yv9CXCsKeUQmYtwWfzAqJIkRrCPvFNoWcTIiyPghHc5x7mEGozh2wvrjQk40ccIbtP/GvsaWqoXUcES9Oqqc+dsq2NR90VRrJN1ot1P0IYV6dOqYbY0a4j6nBzm8oKT6ZPVrH6IlrrDfAgwAzy637RMlrY0AAAAASUVORK5CYII=">
                                Google+
                            </a>
                        </div>
                        <div class="form-group">
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                    </span>
                                    <input type="email" class="form-control" name="email" id="email"
                                           placeholder="Enter your Email Id" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                    </span>
                                    <input type="password" class="form-control" name="password" id="password"
                                           placeholder="Enter your Password" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <button type="button" class="btn-primarybutton btn-lg btn-block login-button">Login</button>
                        </div>
                        {{--<div class="forgotpassword"><a href="forgot-password.html" target="_blank">Forgot Password</a></div>--}}
                        {{ajaxFormFields('login_v2')}}
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane {{($route == 'register') ? 'active' : ''}}" id="profile">
                    <form class="form-horizontal" method="post" action="#" id="register_form">
                        <div class="signup">Sign Up</div>
                        <div class="form-group">
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    </span>
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="Enter your Name" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                    </span>
                                    <input type="text" class="form-control" name="email" id="email"
                                           placeholder="Enter your Email Id" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                    </span>
                                    <input type="password" class="form-control" name="password" id="password"
                                           placeholder="Enter your Password" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
                                    </span>
                                    <input type="password" class="form-control" name="confirm" id="confirm"
                                           placeholder="Confirm your Password" required/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <button type="button" class="btn-primarybutton btn-lg btn-block register-button">Register
                            </button>
                        </div>
                        {{ajaxFormFields('register_v2')}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(document).on('click', '.register-button', function () {
            var form = document.getElementById('register_form');
            $('.errors').html('');

            error = validateForm(form);

            if (error.length == 0) {
                $('.errors').html('').hide();
                $('#loadergif').show();

                sendFormRequest(form, 'post', function (response) {
                    $('.success').html("Registration Success..!").show();
                });
            }
        });

        $(document).on('click', '.login-button', function () {
            var form = document.getElementById('login_form');
            $('.errors').html('');

            error = validateForm(form);

            if (error.length == 0) {
                $('.errors').html('').hide();
                $('#loadergif').show();

                sendFormRequest(form, 'post', function (response) {
                    $('.success').html("Login Success..!").show();
                });
            }
        });
    });
</script>