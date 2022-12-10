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
        $allergy_name = $_REUEST['allergy_name'];
        $allergy_desc = $_REQUEST['allergy_desc'];
<p>
        echo "$allergy_name";
        </p>
<p>
        echo "$allergy_desc";
        </p>
        


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO allergies (allergy_name, allergy_desc)
          VALUES ('$allergy_name', '$allergy_desc')";

if (mysqli_query($conn, $sql)) {
    echo "Record inserted into Allergies Correctly";
    echo nl2br("\n$allergy_name\n");
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
  ?>
    </center>
</body>

</html>
