<html>
	<head>
		<title>Dashboard</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

		<link href='https://fonts.googleapis.com/css?family=Allura' rel='stylesheet' type='text/css'>
			
		
	</head>
	<style type="text/css">
		body {
			background-image: url("background.jpg");
			margin: 0;
			padding: 0;
		}
		.weird-font-large{
			font-size: 400%;
			color : #56cef4;
			font-family: 'Allura', cursive;
		}
		.weird-font-small{
			color : #56cef4;
			font-family: 'Allura', cursive;
		}
		h2,h1 {
			text-align: center;
			font-size: 150%;
		}
		form {
			text-align: center;
		}
		.sec {
			padding: 50px 50px;
		}
		button {
			text-align: left;
		}
		.container {
			font-size: 200%;
			color : #56cef4;
			font-family: 'Allura', cursive;
			text-align: center;
		}
		h3 {
			font-size:
		}
		.collapse {
			padding : 20px 20px;
		}
        .dropbtn {
            background-color: #f9f9f9;
            color: white;
            font-size: 30px;
            padding: 12px 16px;
            border: none;
            float: left;
        }

        .dropdown {
            position: relative;
            display: inline-block;
            float: left;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            float:left;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            width: 200px;
            text-decoration: none;
            display: block;
            
        }

        .dropdown-content a:hover {
            background-color: #56cef4 
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
        
		.description {
            text-color : #9AF8FF;
            text-align : center;
            padding: 20px;
            text-font: "Allura";
            background-color: "none";
        }
        
        .cv {
            display: block;
			font-size: 100%;
        }
		.resume {
			display: block;
			font-size: 98%;
			padding-bottom: 26px;
		}
		.biodata {
            display:"block";
			font-size: 88%;
			padding-bottom: 22px;
        }
		.templates {
			padding : 30px 30px;
		}
		a {
			color :  #56cef4;
			font-family: 'Allura', cursive;
			font-size: 100%;
		}
				
        </style>
    
	<body>
		<button type="button" class="btn btn-danger btn-lg" style="float:right; top: 10px; margin-right: 10px; font-family: 'Allura'" data-toggle="modal" data-target="#myModal"><i class="fa fa-power-off"></i></button>
		<h1 class= "weird-font-large"><?= $username ?>'s Dashboard</h1>
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Logout</h4>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to logout?</p>
					</div>
					<div class="modal-footer">
						<a class="btn btn-success" href="/home">Yes</a>
						<a class="btn btn-danger" data-dismiss="modal">No</a>
					</div>
				</div>
      
			</div>
		</div>
		<div class="container">
			<ul class="nav nav-tabs nav-justified">
				<li class="active"><a data-toggle="tab" href="#cv"><i class="fa fa-cog"></i>  CV Options</a></li>
				<li><a data-toggle="tab" href="#personal"><i class="fa fa-male"></i>  Personal Details</a></li>
				<li><a data-toggle="tab" href="#work"><i class="fa fa-industry"></i>  Work Experience</a></li>
				<li><a data-toggle="tab" href="#education"><i class="fa fa-graduation-cap"></i> Educational Details</a></li>
			 </ul>

			<div class="tab-content">
				<div id="cv" class="tab-pane fade in active" >
		            <h2>Select a Template</h2>
					<div class="templates">
						<div class="row">
							<div class="col-sm-4">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3> CV </h3>
									</div>
									<div class="panel-body">
										<p class = "cv description">Projects. Internships. Academics. And you are getting ready to go on board with the first of your real jobs. If this is your story, then go ahead and create your <strong>CV</strong>, highlighting your academics, projects and internships.</p>
									</div>
									<div class="panel-footer">
										<a class="btn btn-info btn-lg" href="/cv?user_id=<?php echo $_GET['user_id'];?>">Create CV  <i class="fa fa-chevron-right"></i></a>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3> Resume </h3>
									</div>
									<div class="panel-body">
										<p class = "resume description">Does your experiences in the industry define your personnel? Then go ahead to make your <strong>Resume</strong> that will highlight your tresure chest of knowledge and encourage employers across the globe to hire you. GO AHEAD! Make the mark!</p>
									</div>
									<div class="panel-footer">
										<a class="btn btn-info btn-lg" href="/resume?user_id=<?php echo $_GET['user_id'];?>">Create Resume  <i class="fa fa-chevron-right"></i></a>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3> Bio-data </h3>
									</div>
									<div class="panel-body">
										<p class = "biodata description">Stepping your first few steps in this wide world named "INDUSTRY"? Well you are at the right place. A Biodata will wrap up the "you" that you are in the most effective way and help you reach out to the world. So start making your <strong>Biodata</strong> and give a kick start to your career NOW!!</p>
									</div>
									<div class="panel-footer">
										<a class="btn btn-info btn-lg" href="/biodata?user_id=<?php echo $_GET['user_id'];?>">Create Bio-data  <i class="fa fa-chevron-right"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="personal" class="tab-pane fade">
					<h2>Personal Details</h2>
					<div class='sec'>
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h2><?= $personal['name'] ?></h3>
							</div>
							<div class="panel-body">
								<p>
									<strong>Phone : </strong><?= $personal['phone'] ?><br>
									<strong>Email : </strong><?= $personal['email'] ?><br>
									<strong>Address : </strong><?= $personal['address'] ?><br>
									<strong>Date of Birth: </strong><?= $personal['dob'] ?><br>
                                    <strong>Father's Name: </strong><?= $personal['fname'] ?><br>
                                    <strong>Hobby: </strong><?= $personal['hobby'] ?><br>
                                    <strong>Objective: </strong><?= $personal['objectives'] ?><br>
									<?= $personal['achievements'] ?>
								</p>
							</div>
						</div>
					</div>
					<div class='sec'>
						<button class= 'btn btn-primary btn-lg' data-toggle="collapse" data-target="#new_personal"><i class="fa fa-plus"></i>Add</button>
						<div id="new_personal" class="collapse">
							<form role="form" method="POST" action="/addPersonal">
								<div class = "form-group" style = "display : none ">
									<input type="text" name="user_id" id ="user_id" value = "<?= $user_id ?>"></input>
								</div>
								
								<div class = "form-group">
									<label for="name" class="weird-font-small"> Name </label>
									<input type="text" name="name" id ="name" value="<?= isset($personal['name'])?$personal['name']:"" ?>"></input>
								</div>
                                <div class = "form-group">
									<label for="fname" class="weird-font-small"> Father's Name </label>
									<input type="text" name="fname" id ="fname" value="<?= isset($personal['fname'])?$personal['fname']:"" ?>"></input>
								</div>
								<div class = "form-group">
									<label for="phone" class="weird-font-small"> Phone </label>
									<input type="text" name="phone" id="phone" value="<?= isset($personal['phone'])?$personal['phone']:"" ?>"></input>
								</div>
								<div class = "form-group">
									<label for="email" class="weird-font-small"> Email</label>
									<input type="text" name="email" id ="email" value="<?= isset($personal['email'])?$personal['email']:"" ?>"></input>
								</div>
								<div class = "form-group">
									<label for="dob" class="weird-font-small"> Date of Birth </label>
									<input type="text" name="dob" id ="dob" value="<?= isset($personal['dob'])?$personal['dob']:"" ?>"></input>
								</div>
                                <div class = "form-group">
									<label for="hobby" class="weird-font-small"> Hobby </label>
									<input type="text" name="hobby" id ="hobby" value="<?= isset($personal['hobby'])?$personal['hobby']:"" ?>"></input>
								</div>
								<div class = "form-group">
									<label class="weird-font-small" style = "display : block"> Address </label>
									<textarea rows="4" cols="50" name="address" id="address"><?= isset($personal['address'])?$personal['address']:"" ?></textarea>
								</div>
                                <div class = "form-group">
									<label class="weird-font-small" style = "display : block"> Career Objective </label>
									<textarea rows="4" cols="50" name="objectives" id="objectives"><?= isset($personal['objectives'])?$personal['objectives']:"" ?></textarea>
								</div>
								<div class = "form-group">
									<label class="weird-font-small" style = "display : block"> Achievements </label>
									<textarea rows="4" cols="50" name="achievements" id="achievements"><?= isset($personal['achievements'])?$personal['achievements']:"" ?></textarea>
								</div>
								<input type="submit" class ="btn btn-primary btn-lg" value="Add"></input>
							</form>
						</div>
					</div>
				</div>
				<div id="work" class="tab-pane fade">
					<h2>Work Experience</h2>
					<div class='sec'>
						<div class='row'>
							<?php 
							foreach($work as $wk)
							{ ?>
								<div class="col-sm-4">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<h2><?= $wk['position'] ?></h2>
											<h3>At <strong><?= $wk['organisation'] ?></strong></h3>
										</div>
										<div class="panel-body">
											<p><?= $wk['details'] ?></p>
											<p><?= $wk['achievements'] ?></p>
										</div>
										<div class="panel-footer">
											Duration : <span><?= $wk['duration'] ?> months</span>											
										</div>
										<div class="panel-footer">
											<button class="btn btn-lg btn-danger" onclick="delWork('<?= $wk["_id"] ?>')"><i class="fa fa-trash"></i></button>
										</div>
									</div>									
								</div>
							<?php } ?>
						</div>
					</div>
					<div class='sec'>
						<button class= 'btn btn-primary btn-lg' data-toggle="collapse" data-target="#new_work"><i class="fa fa-plus"></i>Add New</button>
						<div id="new_work" class="collapse">
							<form role="form" method="POST" action="/addWork">
								<div class = "form-group" style = "display : none ">
									<input type="text" name="user_id" id ="user_id" value = "<?= $user_id ?>"></input>
								</div>
								
								<div class = "form-group">
									<label for="organisation" class="weird-font-small"> Organisation </label>
									<input type="text" name="organisation" id ="organisation"></input>
								</div>
								<div class = "form-group">
									<label for="position" class="weird-font-small"> Position </label>
									<input type="text" name="position" id="position"></input>
								</div>
								<div class = "form-group">
									<label for="duration" class="weird-font-small"> Duration (in months)</label>
									<input type="text" name="duration" id ="duration"></input>
								</div>
								<div class = "form-group">
									<label class="weird-font-small" style = "display : block"> Details </label>
									<textarea rows="4" cols="50" name="details" id="details"></textarea>
								</div>
								<div class = "form-group">
									<label class="weird-font-small" style = "display : block"> Achievements </label>
									<textarea rows="4" cols="50" name="achievements" id="achievements"></textarea>
								</div>
								<input type="submit" class ="btn btn-primary btn-lg" value="Add"></input>
							</form>
						</div>
					</div>
				</div>
				<div id="education" class="tab-pane fade">
					<h2>Educational Details</h2>
					<div class='sec'>
						<div class='row'>
							<?php 
							foreach($edu as $ed)
							{ ?>
								<div class="col-sm-4">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<h2><?= $ed['degree'] ?></h2>
											<h3>From <strong><?= $ed['institution'] ?></strong></h3>
										</div>
										<div class="panel-body">
											<p>Passed with <?= $ed['percentage'] ?> percent marks in all fields</p>
											<p><?= $ed['achievements'] ?></p>
										</div>
										<div class="panel-footer">
											Batch of <?= $ed['end_year'] ?> </span>										
										</div>
										<div class="panel-footer">
											<button class="btn btn-lg btn-danger" onclick="delEdu('<?= $ed["_id"] ?>')"><i class="fa fa-trash"></i></button>
										</div>
									</div>
								</div>
						<?php } ?>
						</div>
					</div>
					<div class='sec'>
						<button class= 'btn btn-primary btn-lg' data-toggle="collapse" data-target="#new_education"><i class="fa fa-plus"></i>Add New</button>
						<div id="new_education" class="collapse">
							<form role="form" method="POST" action="/addEducation">
								<div class = "form-group" style = "display : none ">
									<input type="text" name="user_id" id ="user_id" value = "<?= $user_id ?>"></input>
								</div>
								
								<div class = "form-group">
									<label for="degree" class="weird-font-small"> Degree </label>
									<input type="text" name="degree" id ="degree"></input>
								</div>
								<div class = "form-group">
									<label for="institution" class="weird-font-small"> Institution </label>
									<input type="text" name="institution" id="institution"></input>
								</div>
								<div class = "form-group">
									<label for="percentage" class="weird-font-small"> Percentage of Marks </label>
									<input type="text" name="percentage" id ="percentage"></input>
								</div>
								<div class = "form-group">
									<label for="end_year" class="weird-font-small"> End Year </label>
									<input type="text" name="end_year" id ="end_year"></input>
								</div>
								<div class = "form-group">
									<label class="weird-font-small" style = "display : block"> Achievements </label>
									<textarea rows="4" cols="50" name="achievements" id="achievements"></textarea>
								</div>
								<input type="submit" class ="btn btn-primary btn-lg" value="Add"></input>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script>
		function delWork(id){
			var data = {"id" : id};
			$.post("/deleteWork",data,function(response){
				console.log("Deleted "+response);
				location.href="/dashboard?user_id=<?= $_GET['user_id'] ?>";
			});
		};
		
		function delEdu(id){
			var data = {"id" : id};
			$.post("/deleteEducation",data,function(response){
				console.log("Deleted "+response);
				location.href="/dashboard?user_id=<?= $_GET['user_id'] ?>";
			});
		};
	</script>
</html>