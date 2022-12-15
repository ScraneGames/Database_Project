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

        echo "Nurse less 5 is " . $_REQUEST['nurse_less_5'];
        echo "<br>";
        echo "All nurses is " . $_REQUEST['all_nurse'];
        echo "<br>";
        echo "Patient is " . $_REQUEST['patient'];

        if ($_REQUEST['nurse_less_5'] == TRUE) {
            $nurse = $_REQUEST['nurse_less_5'];
        } else {
            $nurse = $_REQUEST['all_nurse'];
        }


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO nurse_inpatient_assignments (fk_assignment_nurse_id, fk_assignment_patient_id)
                VALUES ('$nurse', '$patient')";


        if(mysqli_multi_query($conn, $sql)){
            echo "<h3>Nurse Assigned successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
            mysql_close($conn);
            ?>
    </center>
</body>

</html>
