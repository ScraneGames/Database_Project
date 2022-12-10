<!DOCTYPE html>
<html>

<head>
    <title> Insert Surgery Skill Page</title>
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
        $skill_name = $_REUEST['skill_name'];
        $skill_desc = $_REQUEST['skill_desc'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = {
          "INSERT INTO surgery_skills (skill_name, skill_desc)
          VALUES ('$skill_name', '$skill_desc')";
        }

        if(mysqli_query($conn, $sql)){
            echo "<h3>Information added successfully.";

            echo nl2br("\n$skill_name\n");
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
