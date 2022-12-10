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
require "../library.php";
connectdatabase()
        // check Connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $corporation_name = $_REUEST['corporation_name'];
        $headquarters = $_REQUEST['headquarters'];
        $shares = $_REQUEST['shares'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = {
          "INSERT INTO owners (name, shares)
          VALUES ('$corporation_name', '$shares')
          INSERT INTO medical_corporations (corporation_name, headquarters, fk_medical_corporations_ownership_id);
          VALUES ('$corporation_name', '$headquarters', LAST_INSERT_ID())";
        }

        if(mysqli_query($conn, $sql)){
            echo "<h3>Information added successfully.";

            echo nl2br("\n$corporation_name\n added!");
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
