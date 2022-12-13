<!DOCTYPE html>
<html>

<head>
    <title> Insert Allergy Page</title>
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

$primary_check_sql = "SELECT fk_primary_physician_id FROM patient_primary WHERE fk_primary_physician_id = (SELECT physician_id FROM physicians WHERE employee_id = '$original_employee_id')";
$primary_check_result = mysqli_query($conn,$owner_sql);

if ($user['position'] == "nurse"){
        $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'";
    } elseif ($user['position'] == "surgeon") {
        $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'";
        } elseif ($user['position'] == "physician" ) {
            if (mysqli_num_rows($primary_check_result) > 0) {
                $replace_primary_sql = "UPDATE patient_primary
                                        SET fk_primary_physician_id = (SELECT physician_id FROM physicians WHERE position = 'chief_of_staff')
                                        WHERE fk_primary_physician_id = '$original_employee_id'";
                if (mysqli_query($conn, $replace_primary_sql)) {
                    echo "Replaced Existing Primary Physicians With Chief of Staff Correctly";
                    echo "<br>";
                    } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
                if (mysqli_num_rows($owner_result) > 0) {
                    $delete_owner_sql = "DELETE FROM owners WHERE ownership_id = (SELECT fk_physician_own_ownership_id FROM physician_owners WHERE fk_own_physician_id = (SELECT physician_id FROM physicians WHERE employee_id = '$original_employee_id')); "
                    if (mysqli_query($conn, $delete_owner_sql)) {
                        echo "Deleted the Physician's Ownership Record Correctly";
                        echo "<br>";
                        } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
                $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'";
                } elseif ($user['position'] == "janitor" || $user['position'] == "secretary") {
                $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'";
            } elseif ($user['position'] == "chief_of_staff") {
                if (mysqli_num_rows($primary_check_result) > 0) {
                    echo "<br>";
                    echo "The chief of staff has primary patients assigned. Please reassign those patients to new primary doctors before proceeeding.";
                    echo "<br>";

                } else {
                    if (mysqli_num_rows($owner_result) > 0) {
                        $delete_owner_sql = "DELETE FROM owners WHERE ownership_id = (SELECT fk_physician_own_ownership_id FROM physician_owners WHERE fk_own_physician_id = (SELECT physician_id FROM physicians WHERE employee_id = '$original_employee_id')); "
                        if (mysqli_query($conn, $delete_owner_sql)) {
                            echo "Deleted the Physician's Ownership Record Correctly";
                            echo "<br>";
                            } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                            $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'";
                        }
                    }
                    $delete_sql = "DELETE FROM staff WHERE employee_id = '$original_employee_id'";
                }
            }


if (mysqli_query($conn, $delete_sql)) {
    echo "Staff Member Deleted Correctly";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

  $conn->close();

?>