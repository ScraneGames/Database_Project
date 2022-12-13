<!DOCTYPE html>
<html>

<head>
    <title> Insert Beds Page</title>
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


        // Taking all the values from the add-beds.php
        $nursing_unit = $_REQUEST['nursing_unit'];
        $wing = $_REQUEST['wing'];
        $room_number = $_REQUEST['room_number'];
        $bed_number = $_REQUEST['bed'];

echo "$nursing_unit";
echo "$wing";
echo "$room_number";
echo "$bed_number";
        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO beds (nursing_unit, wing, room_number, bed_number)
          VALUES ('$nursing_unit', '$wing', '$room_number', '$bed_number')";

if (mysqli_query($conn, $sql)) {
    echo "Record inserted into Beds Correctly";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
            ?>
    </center>
</body>

</html>
