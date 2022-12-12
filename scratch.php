<!DOCTYPE html>
<html>

<head>
    <title> Update Staff Page</title>
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
        $employee_id = $_REQUEST['employee_id'];
        $employee_name = $_REQUEST['employee_name'];
        $ssn = $_REQUEST['ssn'];
        $gender = $_REQUEST['gender'];
        $position = $_REQUEST['position'];
        $address = $_REQUEST['address'];
        $telephone_number = $_REQUEST['telephone_number'];
        $salary = $_REQUEST['salary'];
        $grade = $_REQUEST['grade'];
        $specialty = $_REQUEST['specialty'];
        $own = $_REQUEST['own'];
        $shares = $_REQUEST['shares'];
        $experience = $_REQUEST['experience'];
        $type = $_REQUEST['contract_type'];
        $length = $_REQUEST['contract_length'];
        // Performing insert query execution
        // here for our table name is staff
        $owner_sql = "SELECT fk_own_physician_id FROM physician_owners WHERE fk_own_physician_id = (SELECT physician_id FROM physicians WHERE employee_id = '$employee_id')";
        $result = mysqli_query($conn,$owner_sql);
        echo "$owner_sql";
        echo "<br>";
        echo "<br>";
        // Nurses
if ($position == "nurse") {
          $sql = "UPDATE staff
                  SET employee_name = '$employee_name', ssn = '$ssn', gender = '$gender', address =  '$address', telephone_number =  '$telephone_number'
                  WHERE employee_id = '$employee_id'; ";
          $sql .= "UPDATE nurses
                  SET grade = '$grade', experience = '$experience'
                  WHERE employee_id = $employee_id; ";
          $sql .= "UPDATE salaries (fk_salary_employee_id, salary, fk_salary_position)
                   SET salary = '$salary'
                   WHERE fk_salary_employee_id = '$employee_id'";
    } elseif ($position == "physician" || $position == "chief_of_staff") {
        if (mysqli_num_rows($result) > 0) {
                    $sql .= "UPDATE owners
                        SET fk_owner_name = '$employee_name'
                        WHERE ownership_ID = (SELECT fk_physician_own_ownership_id FROM physician_owners WHERE fk_own_physician_id = (SELECT physician_id FROM physicians WHERE employee_id = '$employee_id')); ";
                    $sql = "UPDATE staff
                        SET employee_name = '$employee_name', ssn = '$ssn', gender = '$gender', address =  '$address', telephone_number =  '$telephone_number'
                        WHERE employee_id = '$employee_id'; ";
                    $sql .= "UPDATE salaries (fk_salary_employee_id, salary, fk_salary_position)
                        SET salary = '$salary'
                        WHERE fk_salary_employee_id = '$employee_id'; ";
                    $sql .= "UPDATE physicians
                        SET specialty = '$specialty'
                        WHERE employee_id = '$employee_id'";
            } else {
                    $sql = "UPDATE staff
                        SET employee_name = '$employee_name', ssn = '$ssn', gender = '$gender', address =  '$address', telephone_number =  '$telephone_number'
                        WHERE employee_id = '$employee_id'; ";
                    $sql .= "UPDATE salaries (fk_salary_employee_id, salary, fk_salary_position)
                        SET salary = '$salary'
                        WHERE fk_salary_employee_id = '$employee_id'; ";
                    $sql .= "UPDATE physicians
                        SET specialty = '$specialty'
                        WHERE employee_id = '$employee_id'";
                    }
               } elseif ($position == "surgeon") {
                        $sql = "UPDATE staff
                            SET employee_name = '$employee_name', ssn = '$ssn', gender = '$gender', address =  '$address', telephone_number =  '$telephone_number'
                            WHERE employee_id = '$employee_id'; ";
                        $sql .= "UPDATE contracts (fk_contracts_employee_id, type, length)
                              SET type = '$contract_type', length = '$contract_length'
                              WHERE fk_contracts_employee_id = '$employee_id'; ";
                        $sql .= "UPDATE surgeons (employee_id, specialty, contract_id )
                                SET $specialty = '$specialty'
                                WHERE employee_id = '$employee_id'";
                  } elseif ($position == "janitor" || $position == 'secretary') {
                            $sql = "UPDATE staff
                                    SET employee_name = '$employee_name', ssn = '$ssn', gender = '$gender', address =  '$address', telephone_number =  '$telephone_number'
                                    WHERE employee_id = '$employee_id'; ";
                            $sql .= "UPDATE salaries (fk_salary_employee_id, salary, fk_salary_position)
                                    SET salary = '$salary'
                                    WHERE fk_salary_employee_id = '$employee_id'";
                     }

// The query gets executed here
if (mysqli_multi_query($conn,$sql)) {
      echo "Record inserted into Staff Correctly";
      echo "$sql";
      } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    echo "<br>";
    echo "$sql";
    echo "<br>";
    echo "$conn";
    echo "<br>";
    var_dump($conn);
            ?>
    </center>
</body>

</html>
