
<div class="col-lg-6 col-md-6 col-sm-12">
    <div class="login-item">
        <h5 class="title-login">@if($type=="login")  {{__("login")}} @else {{__("register")}} @endif {{__('your Account')}}</h5>
        <form class="login"  method="post" action="{{route('auth.postLogin')}}">
            @csrf
            <div class="social-account">
                <h6 class="title-social">{{__('Login with social account')}}</h6>
                <a href="#" class="mxh-item facebook">
                    <i class="icon fa fa-facebook-square" aria-hidden="true"></i>
                    <span class="text">{{__('FACEBOOK')}}</span>
                </a>

            </div>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="form-row form-row-wide">
                <label class="text">{{__('Email')}}</label>
                <input title="username" name="email" type="email" class="input-text">
            </p>
            <p class="form-row form-row-wide">
                <label class="text">Password</label>
                <input title="password" name="password" type="password" class="input-text">
            </p>
            <p class="lost_password">
												<span class="inline">
													<input type="checkbox" id="cb1" name="remmber">
													<label for="cb1" class="label-text">{{__('Remember me')}}</label>
												</span>
                <a href="#" class="forgot-pw">{{__('Forgot password?')}}</a>
            </p>
            <p class="form-row">
                <input type="submit" class="button-submit login_submit" value="login">
            </p>
        </form>
    </div>
</div>

