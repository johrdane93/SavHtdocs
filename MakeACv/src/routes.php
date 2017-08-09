<?php
// Routes
$app->get('/', function ($request, $response, $args) {
	return $response->withRedirect('/home');
});

$app->get('/home', function ($request, $response, $args) {
	return $this->renderer->render($response, 'login.php', $args);
});

$app->post('/login', function ($request, $response, $args) {
	
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$usersTable = $client->swproject->users;
	$user = $usersTable->findOne(['username' => $_POST['username'], 'password' => $_POST['password']]);
	if(is_null($user))
	{
		$args['message']= "Invalid Credentials";
		return $response->withRedirect('/home?'.http_build_query($args));
	}
	else
	{
		$args['user_id'] = (string) $user['_id'];
		return $response->withRedirect('/dashboard?'.http_build_query($args));
	}
});

$app->get('/registration', function ($request, $response, $args) {
	
	return $this->renderer->render($response, 'register.php', $args);
});



$app->post('/register', function ($request, $response, $args) {
	
	$client = new MongoDB\Client("mongodb://localhost:27017");
    if($_POST['newPassword'] != $_POST['confPassword'])
    {  
        $args['message'] = "Passwords do not match!";
        return $response->withRedirect('/registration?'.http_build_query($args));

    }
	$usersTable = $client->swproject->users;
	$user = $usersTable->findOne(['username' => $_POST['newUsername']]);
	if(is_null($user))
	{
		$usersTable->insertOne(['username'=> $_POST['newUsername'], 'password'=> $_POST['newPassword']]);
        return $response->withRedirect('/home?'.http_build_query($args));
	}
	else
	{
		$args['message']= "User already exists";
		return $response->withRedirect('/registration?'.http_build_query($args));
	}
});

$app->get('/dashboard', function ($request, $response, $args) {
	
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$usersTable = $client->swproject->users;
	$personalTable = $client->swproject->personal;
    $workTable = $client->swproject->work;
    $educationTable = $client->swproject->education;
	
	$user_id = new MongoDB\BSON\ObjectId($_GET['user_id']);
	$user = $usersTable->findOne(['_id'=> $user_id ]);
	$args['username'] = $user['username'];
	$args['user_id'] = $_GET['user_id'];
	
	$personal = $personalTable->findOne(['user_id' => $_GET['user_id']]);
    $args['personal'] = $personal;
	
	$cursor1 = $workTable->find(['user_id' => $_GET['user_id']]);
    $work=[];
    foreach($cursor1 as $wk)
    {   
        $work[] = $wk;
    }
    $args['work'] = $work;
    
    $edu = [];
	$cursor2 = $educationTable->find(['user_id' => $_GET['user_id']]);
    foreach($cursor2 as $ed)
    {
        $edu[] = $ed;
    }
    $args['edu'] = $edu;
	
	return $this->renderer->render($response, 'dashboard.php', $args);
});

$app->get('/resume', function ($request, $response, $args) {
	
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$usersTable = $client->swproject->users;
    $personalTable = $client->swproject->personal;
    $workTable = $client->swproject->work;
    $educationTable = $client->swproject->education;
    
	$user_id = $_GET['user_id'];
    
	$personal = $personalTable->findOne(['user_id' => $_GET['user_id']]);
    $args['personal'] = $personal;
	
	$cursor1 = $workTable->find(['user_id' => $_GET['user_id']]);
    $work=[];
    foreach($cursor1 as $wk)
    {   
        $work[] = $wk;
    }
    $args['work'] = $work;
    
    $edu = [];
	$cursor2 = $educationTable->find(['user_id' => $_GET['user_id']]);
    foreach($cursor2 as $ed)
    {
        $edu[] = $ed;
    }
    $args['edu'] = $edu;
    
	return $this->renderer->render($response, 'resume.php', $args);
});


$app->get('/cv', function ($request, $response, $args) {
	
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$usersTable = $client->swproject->users;
    $personalTable = $client->swproject->personal;
    $workTable = $client->swproject->work;
    $educationTable = $client->swproject->education;
    
	$user_id = $_GET['user_id'];
    
	$personal = $personalTable->findOne(['user_id' => $_GET['user_id']]);
    $args['personal'] = $personal;
	
	$cursor1 = $workTable->find(['user_id' => $_GET['user_id']]);
    $work=[];
    foreach($cursor1 as $wk)
    {   
        $work[] = $wk;
    }
    $args['work'] = $work;
    
    $edu = [];
	$cursor2 = $educationTable->find(['user_id' => $_GET['user_id']]);
    foreach($cursor2 as $ed)
    {
        $edu[] = $ed;
    }
    $args['edu'] = $edu;
    
	return $this->renderer->render($response, 'cv.php', $args);
});

$app->get('/biodata', function ($request, $response, $args) {
	
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$usersTable = $client->swproject->users;
    $personalTable = $client->swproject->personal;
    $workTable = $client->swproject->work;
    $educationTable = $client->swproject->education;
    
	$user_id = $_GET['user_id'];
    
	$personal = $personalTable->findOne(['user_id' => $_GET['user_id']]);
    $args['personal'] = $personal;
	
	$cursor1 = $workTable->find(['user_id' => $_GET['user_id']]);
    $work=[];
    foreach($cursor1 as $wk)
    {   
        $work[] = $wk;
    }
    $args['work'] = $work;
    
    $edu = [];
	$cursor2 = $educationTable->find(['user_id' => $_GET['user_id']]);
    foreach($cursor2 as $ed)
    {
        $edu[] = $ed;
    }
    $args['edu'] = $edu;
    
	return $this->renderer->render($response, 'biodata.php', $args);
});


$app->post('/addWork', function ($request, $response, $args) {
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$workTable = $client->swproject->work;
	$workTable->insertOne(['user_id' => $_POST['user_id'], 
						'organisation' => $_POST['organisation'], 
						'position' => $_POST['position'], 
						'duration' => $_POST['duration'],
						'details' => $_POST['details'],
						'achievements' => $_POST['achievements']
					]);
	return $response->withRedirect('/dashboard?user_id=' . $_POST['user_id']);
});
$app->post('/deleteWork', function ($request, $response, $args) {
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$workTable = $client->swproject->work;
	$id = new MongoDB\BSON\ObjectId($_POST['id']);
	$workTable->deleteOne(['_id' => $id]);
	return $_POST['id'];
});
$app->post('/addPersonal', function ($request, $response, $args) {
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$personalTable = $client->swproject->personal;
	$check = $personalTable->findOne(['user_id' => $_POST['user_id']]);
	if($check == null)
	{
		$personalTable->insertOne(['user_id' => $_POST['user_id'], 
						'name' => $_POST['name'], 
						'phone' => $_POST['phone'], 
						'dob' => $_POST['dob'],
						'email' => $_POST['email'],
						'address' => $_POST['address'],
						'achievements' => $_POST['achievements'],
                        'objectives' => $_POST['objectives'],
                        'hobby' => $_POST['hobby'],
                        'fname' => $_POST['fname']
					]);
	}
	else
	{
		$personalTable->updateOne(['user_id' => $_POST['user_id']],
					[ '$set' => [ 'user_id' => $_POST['user_id'],
						'name' => $_POST['name'], 
						'phone' => $_POST['phone'], 
						'dob' => $_POST['dob'],
						'email' => $_POST['email'],
						'address' => $_POST['address'],
						'achievements' => $_POST['achievements'],
                        'objectives' => $_POST['objectives'],
                        'hobby' => $_POST['hobby'],
                        'fname' => $_POST['fname']
					]]);
	}
	return $response->withRedirect('/dashboard?user_id=' . $_POST['user_id']);
});

$app->post('/addEducation', function ($request, $response, $args) {
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$educationTable = $client->swproject->education;
	$educationTable->insertOne(['user_id' => $_POST['user_id'], 
						'degree' => $_POST['degree'], 
						'institution' => $_POST['institution'], 
						'percentage' => $_POST['percentage'],
						'end_year' => $_POST['end_year'],
						'achievements' => $_POST['achievements']
					]);
	return $response->withRedirect('/dashboard?user_id=' . $_POST['user_id']);
});

$app->post('/deleteEducation', function ($request, $response, $args) {
	$client = new MongoDB\Client("mongodb://localhost:27017");
	$educationTable = $client->swproject->education;
	$id = new MongoDB\BSON\ObjectId($_POST['id']);
	$educationTable->deleteOne(['_id' => $id]);
	return $_POST['id'];
});

$app->post('/capture', function ($request, $response, $args) {
	$filename = $_POST['filename'];
	$args['edu'] = $_POST['edu'];
	$args['personal'] = $_POST['personal'];
	$args['work'] = $_POST['work'];
	
	$capture = new \CV\Capture\Capture;
	$capture->load($filename . '.php', $args);
	return print_r($args);
});