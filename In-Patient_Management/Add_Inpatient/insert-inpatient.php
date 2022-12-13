<!DOCTYPE html>
<html>

<head>
    <title> Insert Inpatient Page</title>
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
        $bed = $_REQUEST['bed'];
        $date = $_REQUEST['date'];



        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO inpateints (fk_inpatients_bed_id, fk_inpatients_patient_id, date)
            VALUES ('$bed', '$patient', '$date')";


        if(mysqli_multi_query($conn, $sql)){
            echo "<h3>Inpatient added successfully.";
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
