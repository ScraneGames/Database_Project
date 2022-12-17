<!DOCTYPE html>
<html>

<head>
    <title> Insert Nurse Skills Page</title>
</head>


<body>
    <center>


        <?php
        // Connect to Database
include "/var/www/html/functions.php";
        // check Connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $nurse = $_REQUEST['nurse'];
        $skill = $_REQUEST['skill'];


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO nurse_skills (fk_skills_nurse_id, fk_nurse_skills_skill_id)
                VALUES ('$nurse', '$skill')";


        if(mysqli_multi_query($conn, $sql)){
            echo "<h3>Nurse Skill Assigned successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
            ?>
    </center>
</body>

</html>
