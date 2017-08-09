<html>
	<head>
		<title>Login</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

		<link href='https://fonts.googleapis.com/css?family=Allura' rel='stylesheet' type='text/css'>
			
		<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
		<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
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
			margin: 20px;
			text-align: center;
		}
		.error {
			color : #FF0000;
			font-family: 'Allura', cursive;
			font-size: 250%;
		}
		input {
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
				<form role="form" method="POST" action="/register">
					<div class = "form-group">
						<label for="newUsername" class="weird-font-small"> Enter Username </label>
						<input type="text" name="newUsername" id ="newUsername"></input>
					</div>
					<div class = "form-group">
						<label for="newPassword" class="weird-font-small"> Enter Password </label>
						<input type="text" name="newPassword" id="newPassword"></input>
					</div>
                    <div class = "form-group">
						<label for="confPassword" class="weird-font-small"> Confirm Password </label>
						<input type="text" name="confPassword" id="confPassword"></input>
					</div>
					<input type="submit" class ="btn btn-primary btn-lg" value="Sign Up"> </input>
				</form>
			</div>
		</div>
	</body>
</html>