<!DOCTYPE html>
<html>

<head>
    <title> Insert Surgery Types Page</title>
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
connectdatabase();
        // check Connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $type_name = $_REUEST['type_name'];
        $type_desc = $_REQUEST['type_desc'];
        $anatomical_location = $_REQUEST('anatomical_location');
        $special_needs = $_REQUEST('special_needs');
        $category = $_REQUEST('category');


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO surgery_types (type_name, type_desc, anatomical_location, special_needs, category)
          VALUES ('$type_name', '$type_desc'. '$anatomical_location'. '$special_needs', '$category')";


        if(mysqli_query($conn, $sql)){
            echo "<h3>Information added successfully.";

            echo nl2br("\n$type_name\n");
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
