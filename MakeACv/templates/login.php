<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

		<link href='https://fonts.googleapis.com/css?family=Allura' rel='stylesheet' type='text/css'>
	</head>
	<style type="text/css">
		body {
			background-image: url("background.jpg");
		}
		.weird-font-large{
			font-size: 400%;
			color : #56cef4;
			font-family: 'Allura', cursive;
		}
		.weird-font-small{
			font-size: 200%;
			color : #56cef4;
			font-family: 'Allura', cursive;
		}
		h2 {
			text-align: center;
			font-size: 150%;
		}
		form {
			text-align: center;
		}
		.sec	{
			padding: 50px 50px;
			text-align: center;
		}
		.error {
			color : #FF0000;
			font-family: 'Allura', cursive;
			font-size: 250%;
		}
		a, button, input {
			color :  #56cef4;
			font-family: 'Allura', cursive;
			font-size: 200%;
		}
	</style>
	<body>
		<div class= 'container'>
			<h2 class = 'weird-font-large'> Make a CV </h2>
			<div class="sec">
				<?php if( isset($_GET['message']) && ($_GET['message']!=null) ) { ?>
					<p class="error"> <?= $_GET['message']?> </p>
				<?php } ?>
				<ul class="nav nav-tabs nav-justified">
					<li class="active"><a data-toggle="tab" href="#register">Register</a></li>
					<li><a data-toggle="tab" href="#login">Login</a></li>
				</ul>
				<div class="tab-content">
					<div id="register" class="tab-pane fade in active">
						<div class="sec">
							<p class="weird-font-large"> New user? </p>
							<a class ="btn btn-primary btn-lg" href="/registration"> Register </a>
						</div>
					</div>
					<div id="login" class="tab-pane fade">
						<div class="sec">
							<p class="weird-font-large"> Got an account? </p>
							<form role="form" method="POST" action="/login">
								<div class = "form-group">
									<label for="username" class="weird-font-small"> Username </label>
									<input type="text" name="username" id ="username"></input>
								</div>
								<div class = "form-group">
									<label for="password" class="weird-font-small"> Password </label>
									<input type="password" name="password" id="password"></input>
								</div>
								<input type="submit" class ="btn btn-primary btn-lg" value="Login"> </input>
							</form>
						</div>
					</div>
				</div>
				
			</div>
			<br>
			<br>
			
		</div>
	</body>
</html>