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
        $employee = $_REQUEST['employee_id'];
// check Monday
        if ($_REQUEST['monday'] == 'on'){
            $monday = 1;
        } else{
            $monday = 0;
        }
// check Tuesday
        if ($_REQUEST['tuesday'] == 'on'){
            $tuesday = 1;
        } else{
            $tuesday = 0;
        }
// check Wednesday
        if ($_REQUEST['wednesday'] == 'on'){
            $wednesday = 1;
        } else{
            $wednesday = 0;
        }
// check Thursday
        if ($_REQUEST['thursday'] == 'on'){
            $thursday = 1;
        } else{
            $thursday = 0;
        }
// check Friday
        if ($_REQUEST['friday'] == 'on'){
            $friday = 1;
        } else{
            $friday = 0;
        }
// check Saturday
        if ($_REQUEST['saturday'] == 'on'){
            $saturday = 1;
        } else{
            $saturday = 0;
        }
// check Sunday
        if ($_REQUEST['sunday'] == 'on'){
            $sunday = 1;
        } else{
            $sunday = 0;
        }
        $start_time = $_REQUEST['start_time'];
        $end_time = $_REQUEST['end_time'];

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

        $sql = "INSERT INTO work_schedule (fk_work_schedule_employee_id, monday, tuesday, wednesday, thursday, friday, saturday, sunday, start_time, end_time)
            VALUES ('$employee', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday', '$saturday', '$sunday', '$start_time', '$end_time')";

        if(mysqli_query($conn, $sql)){
            echo "<h3>Work schedule added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
            mysql_close($conn);
            ?>
    </center>
</body>

</html>
