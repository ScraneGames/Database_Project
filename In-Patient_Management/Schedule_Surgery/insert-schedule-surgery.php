<!DOCTYPE html>
<html>

<head>
    <title> Insert Scheduled Surgery Page</title>
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
        $patient = $_REQUEST['patient'];
        $surgery_type = $_REQUEST['surgery_type'];
        $operating_theater = $_REQUEST['operating_theater'];
        $date = $_REQUEST['date'];
        $time = $_REQUEST['time'];
        $surgeon = $_REQUEST['surgeon'];
        $nurse1=$_REQUEST['nurse1'];
        $nurse2=$_REQUEST['nurse2'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO surgery_schedule (patient_id, operating_theater, fk_schedule_surgery_code, fk_schedule_surgeon_id, fk_nurse_id_1, fk_nurse_id_2, date, time)
            VALUES ('$patient', '$operating_theater', '$surgery_type', '$surgeon', '$nurse1', '$nurse2', '$date', '$time'); ";
        $sql .= "INSERT INTO recorded_surgeries (fk_recorded_suregon_id, fk_recorded_surgery_code, fk_recorded_patient_id, surgery_id, date)
            VALUES ('$surgeon', '$surgery_type', '$patient', (SELECT surgery_id FROM surgery_schedule WHERE patient_id = '$patient' AND fk_schedule_surgery_code = '$surgery_type' AND fk_schedule_surgeon_id = '$surgeon' AND date = '$date' AND time = '$time'), '$date'";

        if(mysqli_multi_query($conn, $sql)){
            echo "<h3>Surgery Scheduled Successfully.";
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
