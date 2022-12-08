<!DOCTYPE html>
<html>

<head>
    <title> Insert Allergy Page</title>
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


        // Taking all the values from the add-beds.php
        $nursing_unit = $_REUEST['nursing_unit'];
        $wing = $_REQUEST['wing'];
        $room_number = $_REUEST['room_number'];
        $bed_number = $_REQUEST['bed_number'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = {
          "INSERT INTO beds (nursing_unit, wing. room_number, bed_number)
          VALUES ('$nursing_unit', '$wing', '$room_number', '$bed_number')";
        }

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
