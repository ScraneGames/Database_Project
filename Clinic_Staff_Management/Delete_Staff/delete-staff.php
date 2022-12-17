<!DOCTYPE html>
<html lang="en">

<head>
    <title> Delete Staff Page</title>
</head>


<body>
    <center>

<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$original_employee_id = $_REQUEST['employee'];


$sql = "SELECT * FROM staff WHERE employee_id = '$original_employee_id'";

$result = mysqli_query($conn,$sql);

$user = mysqli_fetch_array($result,MYSQLI_ASSOC);

$owner_sql = "SELECT fk_own_physician_id FROM physician_owners WHERE fk_own_physician_id = (SELECT physician_id FROM physicians WHERE employee_id = '$original_employee_id')";
$owner_result = mysqli_query($conn,$owner_sql);

$primary_check_sql = "SELECT primary_physician_id FROM patient_medical_data WHERE primary_physician_id = (SELECT physician_id FROM physicians WHERE employee_id = '$original_employee_id')";
$primary_check_result = mysqli_query($conn,$primary_check_sql);

$primary_array = mysqli_fetch_array($primary_check_result,MYSQLI_ASSOC);

$primary_id = $primary_array['primary_physician_id'];

$inpatient_check_sql = "SELECT attending_physician_id FROM inpatients WHERE attending_physician_id = (SELECT physician_id FROM physicians WHERE employee_id = '$original_employee_id')";
$inpatient_check_sql_result = mysqli_query($conn,$inpatient_check_sql);


// delete nurse

//l if ($user['position'] == "nurse"){
//l        $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'";
//l    }
    // delete surgeon
//l    elseif ($user['position'] == "surgeon") {
//l        $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'";
    //l    }
        // delte physician
        // Turn this to an elseif when you undelete everything else

        if ($user['position'] == "physician" ) {

            // Check if a primary physician and if so, replace the primary physician id in patient_medical data
            // with the physician id of the chief of staff
        //l    if (mysqli_num_rows($primary_check_result) > 0) {
        //l        $replace_primary_sql = "UPDATE patient_medical_data
        //l                                SET primary_physician_id = (SELECT physician_id FROM physicians WHERE position = 'chief_of_staff')
        //l                                WHERE primary_physician_id = '$primary_id';";
//l
       //l        echo "$replace_primary_sql";
       //l        if (mysqli_query($conn, $replace_primary_sql)) {
        //l            echo "Replaced Existing Primary Physicians With Chief of Staff Correctly";
       //l             echo "<br>";
       //l             } else {
      //l              echo "Error: " . $replace_primary_sql . "<br>" . $conn->error;
      //l          }
      //l      }

            // Check if an attending and if so, replace the primary physician id in patient_medical data
            // with the physician id of the chief of staff

       //l     if (mysqli_num_rows($inpatient_check_sql_result) > 0) {
       //l         $replace_attending_sql = "UPDATE inpatients
       //l                                SET attending_physician_id = (SELECT physician_id FROM physicians WHERE position = 'chief_of_staff')
        //l                                WHERE attending_physician_id = '$primary_id'; ";
//l
       //l         echo "$replace_attending_sql";
       //l         if (mysqli_query($conn, $replace_attending_sql)) {
       //l             echo "Replaced Existing Primary Physicians With Chief of Staff Correctly";
       //l             echo "<br>";
       //l             } else {
      //l             echo "Error: " . $replace_attending_sql . "<br>" . $conn->error;
      //l          }
      //l      }

            // Check if an owner and if so, delete physician from the owners table
           //l     if (mysqli_num_rows($owner_result) > 0) {
          //l          $delete_owner_sql = "DELETE FROM owners WHERE ownership_id =
           //l         (SELECT fk_physician_own_ownership_id
          //l          FROM physician_owners
          //l          WHERE fk_own_physician_id =
          //l          (SELECT physician_id
          //l          FROM physicians
          //l          WHERE employee_id = '$original_employee_id')); ";
//l
        //l            echo "$delete_owner_sql";
          //l        if (mysqli_query($conn, $delete_owner_sql)) {
         //l               echo "Deleted the Physician's Ownership Record Correctly";
          //l              echo "<br>";
          //l              } else {
         //l               echo "Error: " . $sql . "<br>" . $conn->error;
         //l           }
       //l         }


               // Set Delete SQL
               $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'; ";

               echo "$delete_sql";


                }
    //l            // Deletes janitor or secretary
    //l            elseif ($user['position'] == "janitor" || $user['position'] == "secretary") {
    //l            $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'";
    //l        }

            // Delete Chief of Staff

     //l       elseif ($user['position'] == "chief_of_staff") {
//l
    //l            // Check if chief is a primary physician, and if so, throw an error

     //l           if (mysqli_num_rows($primary_check_result) > 0 || mysqli_num_rows($inpatient_check_sql_result) > 0)  {

      //l              if (mysqli_num_rows($primary_check_result) > 0) {
      //l              echo "<br>";
      //l              echo "The chief of staff has primary patients assigned. Please reassign those patients to new primary doctors before proceeeding.";
       //l             echo "<br>";

       //l         }

       //l         if (mysqli_num_rows($inpatient_check_sql_result) > 0) {

       //l                 echo "<br>";
       //l                 echo "The chief of staff has inpatients assigned. Please reassign those patients to new primary doctors before proceeeding.";
        //l                echo "<br>";
       //l         }
       //l      } else {

                    // Check if the chief is a n owner, and if so, delete from owners

      //l              if (mysqli_num_rows($owner_result) > 0) {
      //l                 $delete_owner_sql = "DELETE FROM owners WHERE ownership_id =
       //l                 (SELECT fk_physician_own_ownership_id
       //l                 FROM physician_owners
       //l                 WHERE fk_own_physician_id =
       //l                (SELECT physician_id
        //l                FROM physicians
       //l                 WHERE employee_id = '$original_employee_id')); ";
       //l               echo "$delete_owner_sql";

                      if (mysqli_query($conn, $delete_owner_sql)) {
                          echo "Deleted the Chief of Staff's Ownership Record Correctly";
                            echo "<br>";
                            } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                    $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'";

                    echo "$delete_sql";
                }
            }



if (mysqli_query($conn, $delete_sql)) {
    echo "Staff Member Deleted Correctly";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

  $conn->close();

?>
     </center>
   </body>
</html>
