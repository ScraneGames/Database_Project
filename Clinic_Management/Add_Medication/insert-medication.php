<!DOCTYPE html>
<html>

<head>
    <title> Insert Medication Page</title>
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
        $medication_name = $_REQUEST['medication_name'];
        $quantity_on_hand = $_REQUEST['quantity_on_hand'];
        $quantity_on_order = $_REQUEST['quantity_on_order'];
        $unit_cost = $_REQUEST['unit_cost'];
        $ytd_usage = $_REQUEST['ytd_usage'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO medications (name, quantity_on_hand, quantity_on_order, unit_cost, ytd_usage)
          VALUES ('$medication_name', '$quantity_on_hand', '$quantity_on_order', '$unit_cost', '$ytd_usage')";

if (mysqli_query($conn, $sql)) {
    echo "Record inserted into Medications Correctly";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
            ?>
    </center>
</body>

</html>
