<!DOCTYPE html>
<html>

<head>
    <title> Insert Illness Page</title>
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
        $illness_name = $_REQUEST['illness_name'];
        $illness_desc = $_REQUEST['illness_desc'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO illness (illness_name, illness_desc)
          VALUES ('$illness_name', '$illness_desc')";

if (mysqli_query($conn, $sql)) {
    echo "Record inserted into Illnesses Correctly";
    echo nl2br("\n$illness_name\n");
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
            ?>
    </center>
</body>

</html>
