# dronate
Drone to Donate
This allows people to share their left over or fresh made food with people in this pandemic. The donators can mark their location and someone will reach out to them to collect the food and provide it to needy ones. Similarly people (who are starving) can request food. If they don’t have internet, then someone else can mark location on their behalf.
Someone will pick the food from donators location and provide it to needy ones.

#### Requirements
1) PHP 5.1 or above
2) MySQL database
3) Modern web browser (chrome/firefox)

#### Steps to run the application locally
1) Clone or download the reposity
2) Extract the files in your root folder (www in wamp or htdocs in xamp)
3) Change the credentials in the file db_connection.php (includes/db_connection.php) as per your database
4) Create a new database named "dronate" and import the sql file (database/dronate.sql)
4) Change the name to your localhost URL in utility.php file (includes/utility.php)
5) Open the project in browser
6) Allow location access for the project
