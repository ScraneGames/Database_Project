<!DOCTYPE html>
<html>

<head>
    <title> Insert Patient Page</title>
</head>


<body>
    <center>


        <?php
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dbname = "database_project";

        // Connect to Database
        $conn = new mysqli($servername, $username, $password, $dbname);

        // check Connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php 
        $patient_name = $_REUEST['patient_name'];
        $ssn = $_REQUEST['ssn'];
        $gender = $_REQUEST['gender'];
        $dob = $_REQUEST['dob'];
        $address = $_REQUEST['address'];
        $telephone_number = $_REQUEST['telephone_number']


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO patient_personal_data VALUES ('$patient_name', '$ssn', '$gender', '$dob', '$address', '$telephone_number')";

        if(mysqli_query($conn, $sql)){
            echo "<h3>Information added successfully.";

            echo nl2br("\n$patient_name\n");
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
