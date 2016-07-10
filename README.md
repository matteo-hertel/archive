# 201607LaravelTest

##Brief

This practical test has been designed to enable the candidate in demonstrating the following technical skills:

1. The candidates knowledge of GitHub
2. The ability to use Composer in the installation of a new Laravel
3. To demostrate a basic level of knowledge of the Laravel 5 framework
4. Your analytical and problem solving abilities.

Task:

1. Install a new Laravel 5.* project
2. Create a screen with the following form fields:

    a. input field - should be mandatory and accept only an integer value from 1 to 100
    b. submit button

3. When the form is submitted:

    a. An array should be created which holds values from 1 to 100, however the value that has been entered by the user should be omitted
    b. Without prior knowledge of what number was submitted by the user, a function should be written to return the missing number from the array
    c. Display the missing number to the screen

We would like to see how well you can implement bootstrap & JavaScript.

You are not required to use MySQL/MariaDB to solve the problem, we leave it up to you.

Although not timed, We estimate that the test should run for no more than 2 hours.

4. Please provide installation instructions on how to get the project up and running - these can be bullet pointed, no essays are required! 
5. Once completed, please upload your work to GitHub and invite moin@appsumer.io to the repository. If you do not have a github account, please send the completed work to the same email address.


##Instructions

Please note, the instructions are making the following assumptions:

* PHP is installed available in PATH and all the Laravel dependencies are met
* node, npm and gulp are installed and available in PATH 

simple set up:

* clone the repository and `cd` in

* run `composer install`

* run `npm install && gulp --production`

* run "cd public"

* run `php -S localhost:8080 -t.`

* open [http://localhost:8080](http://localhost:8080) in any browser

* give the app a try!