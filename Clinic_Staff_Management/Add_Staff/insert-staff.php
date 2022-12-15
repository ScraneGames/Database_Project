<!DOCTYPE html>
<html>

<head>
    <title> Insert Staff Page</title>
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

        // Nurses
if ($position == "nurse") {
          $sql = "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
          VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number'); ";
          $sql .= "INSERT INTO nurses (employee_id, grade, experience)
          VALUES ((SELECT employee_id FROM staff WHERE ssn = '$ssn'), '$grade', '$experience'); ";
          $sql .= "INSERT INTO salaries (fk_salary_employee_id, salary, fk_salary_position)
          VALUES ((SELECT employee_id FROM staff WHERE ssn = '$ssn'), '$salary', '$position')";
    } elseif ($position == "physician" || $position == "chief_of_staff") {
          if ($own == "yes") {
            $sql = "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
                    VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number'); ";
            $sql .= "INSERT INTO salaries (fk_salary_employee_id, salary, fk_salary_position)
                    VALUES ((SELECT employee_id FROM staff WHERE ssn = '$ssn'), '$salary', '$position'); ";
            $sql .= "INSERT INTO owners (fk_owner_name, shares)
                    VALUES ('$employee_name', '$shares'); ";
            $sql .= "INSERT INTO physicians (employee_id, position, specialty, employee_name)
                    VALUES ((SELECT employee_id FROM staff WHERE ssn = '$ssn'), '$position', '$specialty', '$employee_name'); ";
            $sql .= "INSERT INTO physician_owners (fk_own_physician_id, fk_own_employee_name, fk_physician_own_ownership_id)
                    VALUES ((SELECT physician_id FROM physicians WHERE employee_id = (SELECT employee_id FROM staff WHERE ssn = '$ssn')), '$employee_name', (SELECT ownership_id FROM owners WHERE fk_owner_name = '$employee_name' AND shares = '$shares'))";
            } else {
                $sql = "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
                    VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number'); ";
                $sql .= "INSERT INTO physicians (employee_id, position, specialty, employee_name)
                    VALUES ((SELECT employee_id FROM staff WHERE ssn = '$ssn'), '$position', '$specialty', '$employee_name'); ";
                $sql .="INSERT INTO salaries (fk_salary_employee_id, salary, fk_salary_position)
                    VALUES ((SELECT employee_id FROM staff WHERE ssn = '$ssn'), '$salary', '$position'); ";
                  }
               } elseif ($position == "surgeon") {
                        $sql = "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
                           VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number'); ";
                        $sql .= "INSERT INTO contracts (fk_contracts_employee_id, type, length)
                              VALUES ((SELECT employee_id FROM staff WHERE ssn = '$ssn'), '$type', '$length'); ";
                        $sql .=  "INSERT INTO surgeons (employee_id, specialty, contract_id )
                          VALUES ((SELECT employee_id FROM staff WHERE ssn = '$ssn'), '$specialty', (SELECT contract_id FROM contracts WHERE fk_contracts_employee_id = (SELECT employee_id FROM staff WHERE ssn = '$ssn'))); ";
                  } elseif ($position == "janitor" || $position == 'secretary') {
                        $salary = $_REQUEST['salary'];
                            $sql = "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
                            VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number'); ";
                            $sql .= "INSERT INTO salaries (fk_salary_employee_id, salary, fk_salary_position)
                            VALUES ((SELECT employee_id FROM staff WHERE ssn = '$ssn'), '$salary', '$position'); ";
                     }

// The query gets executed here
if (mysqli_multi_query($conn, $sql)) {
      echo "Record inserted into Staff Correctly";
      } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    var_dump($conn);
            ?>
    </center>
</body>

</html>
