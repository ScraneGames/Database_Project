<!DOCTYPE html>
<html>

<head>
    <title> Insert Medical Corporation Page</title>
</head>


<body>
    <center>


        <?php
  //      $servername = "localhost";
  //      $username = "username";
  //      $password = "password";
  //      $dbname = "database_project";

        // Connect to Database
//        $conn = new mysqli($servername, $username, $password, $dbname);
include "/var/www/html/functions.php";
// connectdatabase();
        // check Connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $corporation_name = $_REQUEST['corporation_name'];
        $headquarters = $_REQUEST['headquarters'];
        $shares = $_REQUEST['shares'];


        // Performing insert query execution
        // here for our table name is patient_personal_data


        $sql = "INSERT INTO owners (fk_owner_name, shares)
                  VALUES ('$corporation_name', '$shares'); ";
        $sql .= "INSERT INTO medical_corporations (corporation_name, headquarters, fk_medical_corporations_ownership_id)
        		VALUES ('$corporation_name', '$headquarters',(SELECT UNIQUE LAST_INSERT_ID() FROM owners))";

   if (mysqli_query($conn, $sql)) {
              echo "Record inserted into Owners Correctly";
              $last_id = mysqli_insert_id($conn);
            } else {
              echo '$sql'
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
            ?>
    </center>
</body>

</html>
