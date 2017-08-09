#MakeACv

To run the app :

Prequisites - PHP, Composer , MongoDB

1. Open command prompt and run the command `composer install`
2. Navigate to the public/ directory
3. Open command prompt and run the command, `php -S localhost:8080`	
4. Open a web browser and type in the address localhost:8080/

###MongoDB structure

1. Database - swproject
  1. Collection - users
    * user_id (_id)
    * username
    * password
  
  2. Collection - work
    * user_id
    * organisation
    * position
    * duration
    * details
    * achievements
 
  3. Collection - personal
    * user_id
    * name
	* fname
    * phone
    * email
	* hobby
    * dob
    * address
	* objectives
    * achievements

  4. Collection - education
    * user_id
    * degree
    * institution
    * percentage
    * end_year
    * achievements