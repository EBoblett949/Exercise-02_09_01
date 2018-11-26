<!doctype html>
<html>
<head>
    <!-- 
        Exercise 02_09_01
        Author: Eli Boblett
        Date: 11.15.18 
        VerifyLogin.php
     -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Intern Login</title>
    <script src="modernizr.custom.65897.js"></script>
</head>
<body>
    <h1>College Internship</h1>
    <h2>Verify Intern Login</h2>
    <?php 
        $errors = 0;
        $hostname = "localhost";
        $username = "adminer";
        $passwd = "south-proud-55";
        $DBConnect = false;
        $DBName = "internships1";
        if ($errors == 0) {
            $DBConnect = mysqli_connect($hostname, $username, $passwd);
            if (!$DBConnect) {
                ++$errors;
                echo "<p>Unable to connect to database server, error code: " . mysqli_connect_error() . "</p>\n";
            }
            else {
                $result = mysqli_select_db($DBConnect, $DBName);
            }
        }
        $TableName = "interns";
        if ($errors == 0) {
            $SQLstring = "SELECT internID, first, last" . 
            " FROM $TableName" . 
            " WHERE email='" . stripslashes($_POST['email']) . "' AND password_md5='" . md5(stripslashes($_POST['password'])) . "'";
            $queryResult = mysqli_query($DBConnect, $SQLstring);
            if (mysqli_num_rows($queryResult) == 0) {
                ++$errors;
                echo "<p>The email address/password combination entered is not valid";
            } 
            else {
                $row = mysqli_fetch_assoc($queryResult);
                $internID = $row['internID'];
                $internName = $row['first'] . " " . $row["last"];
                mysqli_free_result($queryResult);
                echo "<p>Welcome back, $internName!</p>";
            }  
        }
        if ($DBConnect) {
            echo "closing database \"$DBName\" connection.</p>\n";
            mysqli_close($DBConnect);
            echo "<form action='AvailableOpportunities.php' method='POST'>\n";
            echo "<input type='hidden' name='internID' value='$internID'>\n";
            echo "<input type='submit' name='submit' value='View Available Opportunities'>\n";
            echo "</form>";
        }
        if ($errors > 0) {
            echo "<p>Please use your browsers BACK button to return to the form and fix the errors indicated</p>";
        }
    ?>
</body>
</html>