<!DOCTYPE html>
<html>

<head>
    <title> Delete A Surgery</title>
</head>


<body>
    <center>


        <?php



        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $surgery = $_REQUEST['surgery'];





        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "DELETE FROM surgery_schedule WHERE surgery_id = '$surgery';";

if (mysqli_query($conn, $sql)) {
    echo "Surgery Deleted";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
  ?>
    </center>
</body>

</html>
