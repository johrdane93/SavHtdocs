<html> 
	<head>
		<title>Login</title>
		<!-- Latest compiled and minified CSS -->
		<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' >

		<!-- Optional theme -->
		<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css' >

		<!-- Latest compiled and minified JavaScript -->
		<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js' ></script>
		
		<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
	</head> 
	<body>
		<div class='container'>
			<table class='table table-bordered'> 
				<thead> 
					<th> Username </th> 
					<th> Password </th> 
				<thead> 
				<tbody>
					<?php 
					// assuming $users is stored in $args passed into the renderer
					foreach($users as $user)
						{ ?>
						<tr> 
							<td><?php echo $user['username']; ?> </td> 
							<td><?php echo $user['password']; ?> </td> 
						</tr>
					<?php } ?>
				</tbody> 
			</table>
		</div> 
	</body> 
</html>
	