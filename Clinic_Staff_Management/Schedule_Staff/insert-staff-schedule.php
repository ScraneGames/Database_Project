<!DOCTYPE html>
<html>

<head>
    <title> Insert Staff Schedule Page</title>
</head>


<body>
    <center>


        <?php

        // Connect to Database
include "/var/www/html/functions.php";
        // check Connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $employee = $_REUEST['employee_id'];
        $monday = $_REQUEST['monday'];
        $tuesday = $_REQUEST['tuesday'];
        $wednesday = $_REQUEST['wednesday'];
        $thursday = $_REQUEST['thursday'];
        $friday = $_REQUEST['friday'];
        $saturday = $_REQUEST['saturday'];
        $sunday = $_REQUEST['sunday'];
        $hours = $_REQUEST['hours'];

        echo "Employee ID is $employee";
        echo "<br>";
        echo "Monday is $monday";
        echo "<br>";
        echo "Tuesday is $tuesday";
        echo "<br>";
        echo "Wednesday is $wednesday";
        echo "<br>";
        echo "Thursday is $thursday";
        echo "<br>";
        echo "Friday is $friday";
        echo "<br>";
        echo "Saturday is $saturday";
        echo "<br>";
        echo "Sunday is $sunday";
        echo "<br>";
        echo "Hours are $hours";
        echo "<br>";


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO work_schedule (fk_work_schedule_employee_id, monday, tuesday, wednesday, thursday, friday, saturday, sunday, work_hours)
            VALUES ('$employee', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday', '$saturday', '$sunday', '$hours')";

        if(mysqli_query($conn, $sql)){
            echo "<h3>Work schedule added successfully.";
        } else {
            echo "ERROR: Hush! Sorry $sql. "
                . mysql_error($conn);
        }

        // Close connection
            mysql_close($conn);
            ?>
    </center>
</body>

</html>
