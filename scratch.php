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
        $result_numbers = mysqli_num_rows($result);
        echo "$owner_sql";
        echo "<br>";
        echo $result_numbers
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
        if ( $result_numbers > 0) {
                    $sql = "UPDATE owners
                        SET fk_owner_name = '$employee_name'
                        WHERE ownership_ID = (SELECT fk_physician_own_ownership_id FROM physician_owners WHERE fk_own_physician_id = (SELECT physician_id FROM physicians WHERE employee_id = '$employee_id')); ";
                    $sql .= "UPDATE staff
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

SELECT surgery_id,
(SELECT employee_name
FROM staff
JOIN surgeons
ON staff.employee_id = surgeons.employee_id
JOIN surgery_schedule
ON surgeons.surgeon_id = surgery_schedule.fk_schedule_surgeon_id),
(SELECT employee_name
FROM staff
JOIN nurses
ON staff.employee_id = nurses.employee_id
JOIN surgery_schedule
ON nurses.nurse_id = surgery_schedule.fk_nurse_id_1)
FROM surgery_schedule
JOIN surgeons
ON surgery_schedule.fk_schedule_surgeon_id = surgeons.surgeon_id
JOIN nurses
ON surgery_schedule.fk_nurse_id_1 = nurses.nurse_id
JOIN staff
ON surgeons.employee_id = staff.employee_id
WHERE staff.employee_id = nurses.nurse_id;

DROP VIEW IF EXISTS `Project_DB`.`view_surgeries` ;
USE `Project_DB`;
CREATE  OR REPLACE VIEW view_surgeries
surgery_id, operating_theater, date, surgery_code, surgery_type, category, surgeonid, surgeon) AS
SELECT surgery_schedule.surgery_id, surgery_schedule.operating_theater, surgery_schedule.date, surgery_types.surgery_code, surgery_types.type_name, surgery_types.category, surgery_schedule.fk_schedule_surgeon_id, staff.employee_name
FROM surgery_schedule
JOIN surgery_types
ON surgery_schedule.fk_schedule_surgery_code = surgery_types.surgery_code
JOIN surgeons
ON surgery_schedule.fk_schedule_surgeon_id = surgeons.surgeon_id
JOIN staff
ON staff.employee_id = surgeons.surgeon_id
WHERE surgeon = (SELECT employee_name FROM staff JOIN surgeons on staff.employee_id = surgeons.employee_id AND surgeons.surgeon_id = surgeonid);





nurse1_id, first_nurse, nurse2_id, second_nurse, patient_id, patient_name) AS
SELECT surgery_schedule.surgery_id, surgery_schedule.operating_theater, surgery_schedule.date, surgery_types.type_name, surgery_types.category,
(SELECT employee_name
FROM staff
JOIN surgeons
ON staff.employee_id = surgeons.surgeon_id
WHERE view_surgeries.surgeon_id = surgeons.surgeon_id)

employee_id IN
(SELECT employee_id FROM surgeons
JOIN surgery_schedule
ON surgeons.surgeon_id = surgery_schedule.fk_schedule_surgeon_id)),
(SELECT employee_name
FROM staff
WHERE employee_id IN
( SELECT employee_ID
FROM nurses
JOIN surgery_schedule
ON nurses.nurse_id = surgery_schedule.fk_nurse_id_1)),
(SELECT employee_name
FROM staff
WHERE employee_id IN
( SELECT employee_ID
FROM nurses
JOIN surgery_schedule
ON nurses.nurse_id = surgery_schedule.fk_nurse_id_2)),
(SELECT patient_name
FROM patient_personal_data
WHERE patient_id IN
(SELECT patient_ID
FROM surgery_schedule)),
surgery_schedule.patient_id
FROM surgery_schedule
JOIN surgery_types
ON surgery_schedule.fk_schedule_surgery_code = surgery_types.surgery_code
JOIN patient_personal_data
ON surgery_schedule.patient_id = patient_personal_data.patient_id
JOIN surgeons ON surgery_schedule.fk_schedule_surgeon_id = surgeons.surgeon_id
JOIN staff
ON surgeons.employee_id = staff.employee_id
JOIN nurses
ON surgery_schedule.fk_nurse_id_1 = nurses.nurse_id
WHERE nurses.employee_id = staff.employee_id
AND surgery_schedule.fk_nurse_id_2 = nurses.nurse_id;
