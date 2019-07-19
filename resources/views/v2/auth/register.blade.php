@extends('v2.master')
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
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 PL0">
                <div class="sub-title MT15"><span>Registration</span></div>
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
                            <label>Email / Username*</label>
                            <input type="text" class="form-control" placeholder="Email / Username" name="email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password">
                        </div>

                        <div class="form-group">
                            <label>Name*</label>
                            <input type="text" class="form-control" placeholder="Name" name="name">
                        </div>

                        <div class="form-group">
                            <label>Gender*</label>
                            <input type="radio" value="male" name="gender" id="male"/> <label for="male">Male</label>
                            <input type="radio" value="female" name="gender" id="female"/> <label
                                    for="female">Female</label>

                        </div>

                        <div class="form-group">
                            <label>Interested In Categories:</label>
                            <select multiple="" class="form-control" style="height: 92px;" name="interests">
                                @foreach( $cats as $c )
                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="btn btn-default top-bg">Submit</button>
                        <a href="{{route('login_v2')}}" class="btn btn-default top-bg">Already have an Account !</a>
                    </form>

                </div>
            </div>

            <div class="col-md-3 PR0 PL0">
                <div class="sub-title MT15"><span>MOBILE PHONE PRICE LISTS</span></div>
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
                </ul>
            </div>
        </div>
    </div>
@endsection