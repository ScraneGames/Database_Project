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
        $employee_name = $_REUEST['patient_name'];
        $ssn = $_REQUEST['ssn'];
        $gender = $_REQUEST['gender'];
        $position = $_REQUEST['position'];
        $address = $_REQUEST['address'];
        $telephone_number = $_REQUEST['telephone_number'];


        // Performing insert query execution
        // here for our table name is staff

        // Nurses
if ($position = "nurse") {
      $salary = $_REQUEST['salary'];
      $grade = $_REQUEST['grade'];
      $experience = $_REQUEST['experience'];
          $sql = "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
          VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number')";
          $sql .= "INSERT INTO nurses (employee_id, grade, experience) 
          VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$grade', '$experience')";
          $sql .= "INSERT INTO salaries (fk_salary_employee_id, salary, fk_salary_position)
          VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$salary', '$position')";
    } elseif ($position = "physician") {
        $salary = $_REQUEST['salary'];
        $specialty = $_REQUEST['specialty'];
        $own = $_REQUEST['own'];
          if ($own = "yes") {
            $shares = $_REQUEST['shares'];
            $sql = "INSERT INTO staff employee_name, ssn, gender, position, address, telephone_number)
                    VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number')";
            $sql .= "INSERT INTO physicians (employee_id, position, specialty)
                    VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$position', '$specialty')";
            $sql .= "INSERT INTO salaries (fk_salary_employee_id, salary, fk_salary_position)
                    VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$salary', '$position')";
            $sql .= "INSERT INTO owners (fk_owner_name, shares) 
                    VALUES ((SELECT employee_name FROM staff WHERE employee_id = (SELECT UNIQUE LAST_INSERT_ID() FROM staff)), '$shares')";
            $sql .= "INSERT INTO physician_owners (fk_own_physician_id, fk_own_employee_name, fk_own_owner_id)
                    VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM physicians), (SELECT employee_name FROM staff WHERE employee_id = (SELECT UNIQUE LAST_INSERT_ID() FROM staff), (SELECT UNIQUE LAST_INSERT_ID() FROM owners))";
            } else {
              $sql = "INSERT INTO staff employee_name, ssn, gender, position, address, telephone_number)
                    VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number')";
               $sql .= "INSERT INTO physicians (employee_id, position, specialty)
                    VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$position', '$specialty')";
               $sql .="INSERT INTO salaries (fk_salary_employee_id, salary, fk_salary_position)
                    VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$salary', '$position')";

                  }
               } elseif ($position = "chief") {
                      $salary = $_REQUEST['salary'];
                  $specialty = $_REQUEST['specialty'];
                  $own = $_REQUEST['own'];
                    if ($own = "yes") {
                      $shares = $_REQUEST['shares'];
                      $sql = "INSERT INTO staff employee_name, ssn, gender, position, address, telephone_number)
                              VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number')";
                      $sql .= "INSERT INTO physicians (employee_id, position, specialty)
                              VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$position', '$specialty')";
                      $sql .= "INSERT INTO salaries (fk_salary_employee_id, salary, fk_salary_position)
                              VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$salary', '$position')";
                      $sql .= "INSERT INTO owners (fk_owner_name, shares) 
                              VALUES ((SELECT employee_name FROM staff WHERE employee_id = (SELECT UNIQUE LAST_INSERT_ID() FROM staff)), '$shares')";
                      $sql .= "INSERT INTO physician_owners (fk_own_physician_id, fk_own_employee_name, fk_own_owner_id)
                              VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM physicians), (SELECT employee_name FROM staff WHERE employee_id = (SELECT UNIQUE LAST_INSERT_ID() FROM staff), (SELECT UNIQUE LAST_INSERT_ID() FROM owners))";
                      } else {
                        $sql = "INSERT INTO staff employee_name, ssn, gender, position, address, telephone_number)
                              VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number')";
                        $sql .= "INSERT INTO physicians (employee_id, position, specialty)
                              VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$position', '$specialty')";
                        $sql .="INSERT INTO salaries (fk_salary_employee_id, salary, fk_salary_position)
                              VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$salary', '$position')";

                  }
              } elseif ($position = "surgeon") {
                    $salary = $_REQUEST['salary'];
                    $grade = $_REQUEST['grade'];
                    $experience = $_REQUEST['experience'];
                    $type = $_REQUEST['type'];
                    $length = $_REQUEST['length'];
                    $specialty = $_REQUEST['specialty'];
                        $sql = "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
                            VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number')";
                        $sql .= "INSERT INTO contracts (fk_contracts_employee_id, type, length)
                              VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$type', '$length')";
                        $sql .=  "INSERT INTO surgeons (employee_id, specialty, contract_id ) 
                          VALUES ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$specialty', (SELECT UNIQUE LAST_INSERT_ID() FROM contracts))";
                  } elseif ($position = "janitor" || $position = 'secretary') {
                        $salary = $_REQUEST['salary'];
                            $sql = "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
                            VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number')";
                            $sql .= "INSERT INTO salaries (fk_alary_employee_id, salary, fk_salary_position) ((SELECT UNIQUE LAST_INSERT_ID() FROM staff), '$salary', '$position')";
                      }
    }
    if (mysqli_query($conn, $sql)) {
      echo "Record inserted into Staff Correctly";
      echo nl2br("\n$allergy_name\n");
      } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  
    $conn->close();
            ?>
    </center>
</body>

</html>
