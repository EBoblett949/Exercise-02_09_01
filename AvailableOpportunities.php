<!doctype html>
<html>
<head>
    <!-- 
        Exercise 02_09_01
        Author: Eli Boblett
        Date: 11.19.18 
        AvailableOpportunities.php
     -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Opportunities</title>
    <script src="modernizr.custom.65897.js"></script>
</head>
<body>
<h1>College Internships</h1>
<h2>Available Opportunities</h2>
<?php
        if(isset($_REQUEST['internID'])) {
            $internID = $_REQUEST['internID'];
        } else {
            $internID = -1;
        }
        // debug
        echo "\$internID: $internID\n";
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
                echo "<p>Unable to connect to database server error code: " . mysqli_connect_error() . "</p>\n";
            } else {
                $result = mysqli_select_db($DBConnect, $DBName);
                if (!$result) {
                    ++$errors;
                    echo "<p>Unable to select the database \"$DBName\" error code: " . mysqli_error($DBConnect) . "</p>\n";
                }
            }
        }
        $TableName = "interns";
        if($errors == 0) {
            $SQLstring = "SELECT * FROM $TableName" . " WHERE internID='$internID'";
            $queryResult = mysqli_query($DBConnect, $SQLstring);
            if(!$queryResult) {
                ++$errors;
                echo "<p>Unable to execute the query, error code: " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>\n";
            } else {
                if(mysqli_num_rows($queryResult) == 0) {
                    ++$errors;
                    echo "<p>Invalid Intern ID!</p>\n";
                }
            }
        }
        if($errors == 0) {
            $row = mysqli_fetch_assoc($queryResult);
            $internName = $row['first'] . " " . $row['last'];
        } else {
            $internName = "";
        }
        // debug
        echo "\$internName: $internName";
        if($DBConnect) {
            echo "<p>Closing database \"$DBName\" connection.</p>\n";
            mysqli_close($DBConnect);
        }
    ?>
</body>
</html>