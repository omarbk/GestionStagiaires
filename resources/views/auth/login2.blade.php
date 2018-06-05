<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V17</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">






<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login3/css/util.css">
	<link rel="stylesheet" type="text/css" href="login3/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
			  <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
				
					<span class="login100-form-title p-b-34">
						Account Login
					</span>
					  @csrf
					<div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Type user name">
					 <input  type="email" class="input100{{ $errors->has('password') ? ' is-invalid' : '' }}  " name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Enter Email" required autofocus>

						<span class="focus-input100"></span>
					</div>
					<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
				
						<input id="exampleInputPassword1" type="password" class="input100{{ $errors->has('password') ? ' is-invalid' : '' }} " name="password" placeholder="Password" >
						<span class="focus-input100"></span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Sign in
						</button>
					</div>

					<div class="w-full text-center p-t-27 p-b-239">
						<span class="txt1">
							Forgot
						</span>

						<a href="#" class="txt2">
							User name / password?
						</a>
					</div>
				  <div class="err">
                            @if ($errors->has('email'))
                                <span class="">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            @if ($errors->has('password'))
                                <span class="">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                      </div>

					<div class="w-full text-center">
					     <button type="submit" class="txt3">
                                    {{ __('Login') }}
                         </button>

					</div>
				</form>

				<div class="login100-more" style="background-image: url('images/bg-01.jpg');"></div>
			</div>
		</div>
	</div>
	
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="login3/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login3/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="login3/vendor/bootstrap/js/popper.js"></script>
	<script src="login3/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login3/vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
<!--===============================================================================================-->
	<script src="login3/vendor/daterangepicker/moment.min.js"></script>
	<script src="login3/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="login3/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="login3/js/main.js"></script>

</body>
</html>