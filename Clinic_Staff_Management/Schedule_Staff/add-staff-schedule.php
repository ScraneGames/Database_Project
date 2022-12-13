<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$original_employee_id = $_REQUEST['employee'];


$sql = "SELECT * FROM staff WHERE employee_id = '$original_employee_id'";

$result = mysqli_query($conn,$sql);

$user = mysqli_fetch_array($result,MYSQLI_ASSOC);

echo "$sql";
echo "<br>";
echo "$original_employee_id";
echo "<br>";
echo $user['employee_name'];
echo "<br>";
$position = $user['position'];
echo "$position";
echo "<br>";

?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Add Staff Schedule</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
   </head>
   <body>
      <center>
         <h1>Adding Staff Schedule</h1>
         <form action="insert-staff-schedule.php" method="post">

<p>

                <input type="hidden" name="employee_id" value="<?php echo "$original_employee_id"; ?>" id="employee_id">
                <label for="sunday">Sunday</label>
                <input type="checkbox" name="sunday" id="sunday">
                <br>
                <label for="monday">Monday</label>
                <input type="checkbox" name="monday" id="monday">
                <br>
                <label for="tuesday">Tuesday</label>
                <input type="checkbox" name="tuesday" id="tuesday">
                <br>
                <label for="wednesday">Wednesday</label>
                <input type="checkbox" name="wednesday" id="wednesday">
                <br>
                <label for="thursday">Thursday</label>
                <input type="checkbox" name="thursday" id="thursday">
                <br>
                <label for="friday">Friday</label>
                <input type="checkbox" name="friday" id="friday">
                <br>
                <label for="saturday">Saturday</label>
                <input type="checkbox" name="saturday" id="saturday">
                <br>



<p>
               <label for="hours">Hours:</label>
               <input type="text" name="hours" id="hours">
            </p>

            <input type="submit" value="Schedule">
         </form>
      </center>
</body>


</html>
