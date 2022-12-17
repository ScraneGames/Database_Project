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


$schedule_sql = "SELECT * FROM work_schedule WHERE fk_work_schedule_employee_id = '$employee'";
$schedule_sql_result = mysqli_query($conn,$schedule_sql);

        // Performing insert query execution
        // here for our table name is patient_personal_data
if (mysqli_num_rows($schedule_sql_result) <1){
        $sql = "INSERT INTO work_schedule (fk_work_schedule_employee_id, monday, tuesday, wednesday, thursday, friday, saturday, sunday, start_time, end_time)
            VALUES ('$employee', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday', '$saturday', '$sunday', '$start_time', '$end_time')";
    } else {
        $sql = "UPDATE work_schedule
                SET monday = '$monday', tuesday = '$tuesday',
                    wednesday = '$wednesday', thursday = '$thursday',
                    friday = '$friday', saturday = '$saturday', sunday = '$sunday',
                    start_time = '$start_time', end_time '$end_time'
                WHERE fk_work_schedule_employee_id = '$employee'";
    }

        if(mysqli_query($conn, $sql)){
            echo "<h3>Work schedule added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
            ?>
    </center>
</body>

</html>
