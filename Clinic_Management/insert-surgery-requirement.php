<!DOCTYPE html>
<html>

<head>
    <title> Insert Surgery Requirement</title>
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
        $skill = $_REQUEST['surgery'];
        echo "$allergy_name";
        echo "<br>";
        echo "$allergy_desc";
        echo "<br>";




        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO surgery_requirements (fk_requirement_surgery_code, fk_requirement_skill_id)
          VALUES ('$surgery', '$skill')";

if (mysqli_query($conn, $sql)) {
    echo "Surgery Requirement Inserted Correctly";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
  ?>
    </center>
</body>

</html>
