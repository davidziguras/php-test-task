# php-test-task

The script user_upload.php is instended for command line use to import a csv file of user data into a MySQL database.
The file users.csv is provided as an example user data file.

The user_upload.php script requires write access to a MySQL database named 'php-test-task'

To see all command line options use:
php user_upload.php --help

Server Requirements:
php with mysqli extension
mysql server
mysql client

The following commands were used to install the above for testing on an Ubuntu 18.04 instance
sudo apt install php7.2-cli
sudo apt install php-mysqli
sudo apt install mysql-server
sudo apt install mysql-client-core-5.7

