<!DOCTYPE html>
<html>

<head>
    <title> Insert Nurse Skills Page</title>
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
        $nurse = $_REQUEST['nurse'];
        $surgery = $_REQUEST['surgery'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO nurse_surgery_assignments (nurse_id, surgery_code)
                VALUES ('$nurse', '$surgery')";


        if(mysqli_multi_query($conn, $sql)){
            echo "<h3>Nurse Assigned to the Surgery.";
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
