<div class="col-lg-6 col-md-6 col-sm-12">
    <div class="login-item">
        <h5 class="title-login">{{__('Register now')}}</h5>

        <form class="register"  method="post" action="{{route('auth.register')}}">
            @csrf
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="danger">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <p class="form-row form-row-wide">
                <label class="text">{{__('first_name')}}</label>
                <input title="first name" name="f_name" value="{{old('f_name')}}" type="text" class="input-text">
            </p>
            <p class="form-row form-row-wide">
                <label class="text">{{__('last_name')}}</label>
                <input title="last name" name="l_name" value="{{old('l_name')}}" type="text" class="input-text">
            </p>
            <p class="form-row form-row-wide">
                <label class="text">{{__('Your email')}}</label>
                <input title="email" type="email" name="email" value="{{old('email')}}"  class="input-text">
            </p>
            <p class="form-row form-row-wide">
                <label class="text">{{__('phone')}}</label>
                <input title="phone" type="text" name="phone" value="{{old('phone')}}"  class="input-text">
            </p>

            <p class="form-row form-row-wide">
                <label class="text">{{__('Password')}}</label>
                <input title="pass" type="password" name="password" class="input-text">
            </p>
            <p class="form-row">
                    <span class="inline">
                        <input type="checkbox" id="cb2" name="checkpolicy" >
                        <label for="cb2" class="label-text">{{__('I agree to')}} <span>{{__('Terms & Conditions')}}</span></label>
                    </span>
            </p>
            <p class="">
                <input type="submit" class="button-submit" value="{{__('Register Now')}}">
            </p>
        </form>
    </div>
</div>