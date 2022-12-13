<!DOCTYPE html>
<html>

<head>
    <title> Insert Allergy Page</title>
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
        $medication1 = $_REQUEST['medication1'];
        $medication2 = $_REQUEST['medication2'];
        $severity = $_REQUEST['severity'];
        echo "$medication1";
        echo "<br>";
        echo "$medication2";
        echo "<br>";
        echo "$severity";
        echo "<br>";



        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO medication_reactions (fk_initial_medication_code, fk_reacting_medication, severity)
          VALUES ('$medication1', '$medication2', '$severity')";

if (mysqli_query($conn, $sql)) {
    echo "Medication Reaction Inserted Correctly";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
  ?>
    </center>
</body>

</html>
