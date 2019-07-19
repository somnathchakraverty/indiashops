Hello {{ucwords($user->name)}},<br/><br/>

You have requested to reset the Password. Click <a href="{{url('user/resetPassword?token='.$user->remember_token)}}">HERE</a> to reset the password password.<br/><br/>

Regards,<br/>
Admin