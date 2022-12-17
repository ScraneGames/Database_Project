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
        $patient = $_REQUEST['patient'];


        if ($_REQUEST['primary_less_7']) {
            $primary = $_REQUEST['primary_less_7'];
        } else {
            $primary = $_REQUEST['primary_less_20'];
        }


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "UPDATE inpatients
                SET attending_physician_id = '$primary'
                WHERE fk_inpatients_patient_id = '$patient'";


        if(mysqli_multi_query($conn, $sql)){
            echo "<h3>Physician Assigned successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
          $conn->close();
            ?>
    </center>
</body>

</html>
