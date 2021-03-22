# AWSAPP 
How to setup (Steps)
* Unzip the cloned file or pull to your local repository after initializing git in your application directory. git pull origin https://github.com/Ebenco36/awsapp.git
* Add dms_sample to your mysql database and set the corresponding information in the .env file
* Start your application using the command below in your application directory.
php -S localhost:8000
* Once the command above executes successfully, goto http://localhost:8000/Database/User.php. This helps in migrating the User ralation to the database.
  
* Account can be created by making a post request to http://localhost:8000/register
* User can login to generate a token by making a post request to http://localhost:8000/login.

#API Documentation
Path to swagger.json http://localhost:8000/Documentation/swagger.php
Swagger documentation can be found here http://localhost:8000/Documentation/swagger/dist/index.html
