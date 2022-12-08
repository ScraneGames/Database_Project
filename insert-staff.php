<!DOCTYPE html>
<html>

<head>
    <title> Insert Staff Page</title>
</head>


<body>
    <center>


        <?php
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dbname = "database_project";

        // Connect to Database
        $conn = new mysqli($servername, $username, $password, $dbname);

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
        $telephone_number = $_REQUEST['telephone_number']


        // Performing insert query execution
        // here for our table name is staff

        // Nurses
if ($position = "nurse") {
      $salary = $_REQUEST['salary']
      $grade = $_REQUEST['grade']
      $experience = $_REQUEST['experience']
          $sql = {
            "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
          VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number');
          SET @last = LAST_INSERT_ID();
          INSERT INTO nurses (employee_id, grade, experience) (@last, '$grade', '$experience');
          INSERT INTO salaries (employee_id, salary, position) (@last, '$salary', '$position')";
        }
    } elseif ($position = "physician") {
        $salary = $_REQUEST['salary']
        $specialty = $_REQUEST['specialty']
        $own = $_REQUEST['own']
          if ($own = "yes") {
            $shares = $_REQUEST['shares']
            $sql = {
                "INSERT INTO staff employee_name, ssn, gender, position, address, telephone_number)
                  VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number');
                SET @last = LAST_INSERT_ID();
                SELECT @name := 'employee_name' FROM staff WHERE ssn = '$ssn';
                INSERT INTO physicians (employee_id, position,)
                  (@last, '$position');
                SELECT @pid := 'physician_id' FROM physicians WHERE employee_id = '@last';
                INSERT INTO salaries (employee_id, salary, position)
                  (@last, '$salary', '$position');
                INSERT INTO owners (name, shares) (@name, '$shares');
                INSERT INTO physician_owners (physician_id, owner_id)
                  (@name, LAST_INSERT_ID())":
            } else {
              $sql = {
                  "INSERT INTO staff employee_name, ssn, gender, position, address, telephone_number)
                    VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number');
                  SET @last = LAST_INSERT_ID();
                  SELECT @name := 'employee_name' FROM staff WHERE ssn = '$ssn';
                  INSERT INTO physicians (employee_id, position,)
                    (@last, '$position');
                  INSERT INTO salaries (employee_id, salary, position)
                    (@last, '$salary', '$position')":
                    }
                  }
            }
          } elseif ($position = "chief") {
            $salary = $_REQUEST['salary']
            $specialty = $_REQUEST['specialty']
            $position = 'chief of staff'
            $own = $_REQUEST['own']
              if ($own = "yes") {
                $shares = $_REQUEST['shares']
                $sql = {
                    "INSERT INTO staff employee_name, ssn, gender, position, address, telephone_number)
                      VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number');
                    SET @last = LAST_INSERT_ID();
                    SELECT @name := 'employee_name' FROM staff WHERE ssn = '$ssn';
                    INSERT INTO physicians (employee_id, position,)
                      (@last, '$position');
                    SELECT @pid := 'physician_id' FROM physicians WHERE employee_id = '@last';
                    INSERT INTO salaries (employee_id, salary, position)
                      (@last, '$salary', '$position');
                    INSERT INTO owners (name, shares) (@name, '$shares');
                    INSERT INTO physician_owners (physician_id, owner_id)
                      (@name, LAST_INSERT_ID())":
                        } else {
                          $sql = {
                              "INSERT INTO staff employee_name, ssn, gender, position, address, telephone_number)
                                VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number');
                              SET @last = LAST_INSERT_ID();
                              SELECT @name := 'employee_name' FROM staff WHERE ssn = '$ssn';
                              INSERT INTO physicians (employee_id, position,)
                                (@last, '$position');
                              INSERT INTO salaries (employee_id, salary, position)
                                (@last, '$salary', '$position')":
                              }
                    }
                  }
                } elseif ($position = "surgeon") {
                    $salary = $_REQUEST['salary']
                    $grade = $_REQUEST['grade']
                    $experience = $_REQUEST['experience']
                    $type = $_REQUEST['type']
                    $length = $_REQUEST['length']
                    $specialty = $_REQUEST['specialty']
                        $sql = {
                          "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
                            VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number');
                          SET @last = LAST_INSERT_ID();
                          INSERT INTO contracts (employee_id, type, length)
                            VALUES (@last, '$type', '$length')
                          INSERT INTO surgeons (employee_id, specialty, contract_id ) (@last, '$specialty', LAST_INSERT_ID());"
                      }
                  } elseif ($position = "janitor" || $position = 'secretary') {
                        $salary = $_REQUEST['salary']
                            $sql = {
                              "INSERT INTO staff (employee_name, ssn, gender, position, address, telephone_number)
                            VALUES ('$employee_name', '$ssn', '$gender', '$position', '$address', '$telephone_number');
                            SET @last = LAST_INSERT_ID();
                            INSERT INTO salaries (employee_id, salary, position) (@last, '$salary', '$position')";
                          }
                      }
                }
    }
        if(mysqli_query($conn, $sql)){
            echo "<h3>Information added successfully.";

            echo nl2br("\n$employee_name\n");
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
