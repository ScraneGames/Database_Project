<!DOCTYPE html>
<html>

<head>
    <title> Update Patient Page</title>
</head>


<body>
    <center>


        <?php
//        $servername = "localhost";
//        $username = "username";
//        $password = "password";
//        $dbname = "database_project";

        // Connect to Database
//        $conn = new mysqli($servername, $username, $password, $dbname);
include "/var/www/html/functions.php";
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
        $telephone_number = $_REQUEST['telephone_number'];
        $patient_id = $_REQUEST['patient_id'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "UPDATE patient_personal_data
                SET patient_name ='$patient_name', ssn = '$ssn', gender = '$gender', dob = '$dob', address = '$address', telephone_number = '$telephone_number'
                WHERE patient_id = '$patient_id'";


        if(mysqli_query($conn, $sql)){
            echo "<h3>Information updated successfully.</h3>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
            ?>
    </center>
</body>
</html>
