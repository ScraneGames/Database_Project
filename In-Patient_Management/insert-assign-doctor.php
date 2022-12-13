<!DOCTYPE html>
<html>

<head>
    <title> Insert Nurse Assignment Page</title>
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
        $patient = $_REQUEST['patient_name'];
        $physician= $_REQUEST['physician']


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO physician_inpatient_assignments (physician_id, patient_id)
                VALUES ('$physician', '$patient')";


        if(mysqli_multi_query($conn, $sql)){
            echo "<h3>Physician Assigned successfully.";
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
