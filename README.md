# simple_meeting_scheduler
A very simple meeting schedule system, built with HTML/CSS/JS/PHP/MySQL

# How to Install:

1. Download XAMPP
<https://www.apachefriends.org/index.html>

2. Navigate to xampp/htdocs. (The location of this may vary, depending on where you installed XAMPP).

3. Clone this repository in xampp/htdocs.

4. Open XAMPP. Start "Apache" and "MySQL", can be found at the very top of the module list, presented when the application opens. Make sure not to have Skype running - it can cause unwanted port errors.

5. Open any browser. Browse to localhost/simple_meeting_scheduler/index.php:8080

6. You should see the GUI of the application now. If not, double check all steps. If all else fails, contact me.

# How to Setup the Database:

1. Open the XAMPP GUI.

2. Click the "Shell" button.

3. Login to MySQL with the following command: "mysql -u root".

4. Create and use a database by following the SQL queries in the file "example_sql/setup_DB.txt".

5. Create all the required tables, by running all SQL queries found in the files "example_sql/create_{SOMETHING}_table.txt".

6. Insert some example information, by running all SQL queries found in the files "example_sql/insert_{SOMETHING}.txt".

7. Run the application and test the different features, like inserting meetings.