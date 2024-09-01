<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login form - Track point</title>
  <link href="{{ asset('assets/img/logo.jpg') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
  <link rel="stylesheet" href="{{ asset('loginform_css/style.css') }}">
</head>
<body>
<div class="container">
	<div class="screen">
		<div class="screen__content">
		    <form method="POST" action="{{ route('login') }}">
            @csrf
			
				<div class="login__field" style="margin-top:150px;">
				<h1 style="margin-left:30px; margin-bottom:30px;">Login Form </h1>
					<i class="login__icon fas fa-user"></i>
					<input type="text" name="phone_number" required autofocus class="login__input" placeholder="Phone Number"/>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input id="password" type="password" name="password" required class="login__input" placeholder="Password"/>
				</div>

				<div class="login__field" style="margin-left:20px;">
            		<label for="remember_me" class="inline-flex items-center">
               			 <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
               			 <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
           			 </label>
       			</div>

				<button class="button login__submit">
					{{ __('Log in ') }}
					<i class="button__icon fas fa-chevron-right"></i>
				</button>				
			</form>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>
</body>
</html>
