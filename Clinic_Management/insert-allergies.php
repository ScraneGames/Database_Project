<!DOCTYPE html>
<html>

<head>
    <title> Insert Allergy Page</title>
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



        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $allergy_name = $_REUEST['allergy_name'];
        $allergy_desc = $_REQUEST['allergy_desc'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO allergies (allergy_name, allergy_desc)
          VALUES ('$allergy_name', '$allergy_desc')";

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
