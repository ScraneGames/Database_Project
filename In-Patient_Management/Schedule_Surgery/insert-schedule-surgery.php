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
        $bed  = $_REQUEST['bed'];
        $category = $_REQUEST['category'];

        echo $category['category'];


        if ($_REQUEST['primary_less_7']) {
            $primary = $_REQUEST['primary_less_7'];
        } else {
            $primary = $_REQUEST['primary_less_20'];
        }


        // Performing insert query execution
        // here for our table name is patient_personal_data

        if ($category == 'O'){

        $sql = "INSERT INTO surgery_schedule (patient_id, operating_theater, fk_schedule_surgery_code, fk_schedule_surgeon_id, fk_nurse_id, date, time)
            VALUES ('$patient', '$operating_theater', '$surgery_type', '$surgeon', '$nurse1', '$date', '$time'); ";
         if(mysqli_query($conn, $sql)){
            echo "<h3>Surgery Scheduled Successfully.</h3>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    } else{
            $sql = "INSERT INTO surgery_schedule (patient_id, operating_theater, fk_schedule_surgery_code, fk_schedule_surgeon_id, fk_nurse_id, date, time)
                    VALUES ('$patient', '$operating_theater', '$surgery_type', '$surgeon', '$nurse1', '$date', '$time'); ";
            $sql .= "INSERT INTO inpatients (fk_inpatients_bed_id, fk_inpatients_patient_id, date_of_admission, attending_physician_id)
                    VALUES ('$bed', '$patient', '$date', '$primary')";
     if(mysqli_multi_query($conn, $sql)){
        echo "<h3>Surgery Scheduled Successfully.</h3>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    }

            ?>
    </center>
</body>
<?php   $conn->close(); ?>
</html>
