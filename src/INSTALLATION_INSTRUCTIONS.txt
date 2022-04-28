INSTALLATION INSTRUCTIONS

To install this system you must do the following:

Upload the file expenses.sql to your database. 
It will install the basic structure of the system, and a few interface-related records. 

Create an initial user with the following query replacing the items in brackets
(removing the brackets) with a username (alphanumeric, one word, all lowercase), 
name and a valid email address:

INSERT INTO `user` (`username`,`first_name`,`last_name`,`email`, `is_active`, `role`)
VALUES(
'[username]',
'[first_name]',
'[last_name]',
'[email]',
1,
'admin');

After following all the steps in this document, upon your first login you can click on the
"First Time Logging In" link to have instructions on how to set a new password sent to you 
via email.

If you cannot send emails from your server, you can generate a password to insert into the
password field by creating a  file password.php that contains the following: 

<?php
$my_password = $_GET["password"];
print md5(md5($my_password));

and load the page as 

http://your.server.com/password.php?password=the_password_you_want

Replace "the_password_you_want" part a temporary password, using only letters and numbers. 
Start with a basic password and then change it within the interface once you've logged in.
Within the user interface you can use any characters you want for your password.  

Copy the /application/config/database.default.php to /application/config/database.php 
Make the appropriate changes to the file to match your db server settings

Copy the /application/config/email.defailt.php to /application/config/email.php
Make the appropriate changes there to adapt your site's email sending to
match your server capabilities