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
require "../library.php";
connectdatabase()
        // check Connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $medication_name = $_REUEST['medication_name'];
        $quantity_on_hand = $_REQUEST['quantity_on_hand'];
        $quantity_on_order = $_REQUEST['quantity_on_order'];
        $unit_cost = $_REQUEST['unit_cost'];
        $ytd_usage = $_REQUEST['ytd_usage'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = {
          "INSERT INTO medications (name, quantity_on_hand, quantity_on_order, unit_cost, ytd_usage)
          VALUES ('medication_name', '$quantity_on_hand', '$quantity_on_order', '$unit_cost'. '$ytd_usage')";
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
