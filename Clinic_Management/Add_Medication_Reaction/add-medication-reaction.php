<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_medications = "SELECT name, medication_code FROM medications";

$all_medications = mysqli_query($conn,$sql_find_medications);

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Add Medical reaction</title>
   </head>
   <body>
      <center>
         <h1>Pair a Reaction</h1>

         <form action="insert-reaction.php" method="post">

         <label>Select a Medication</label>
        <select name="medication1">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($medications = mysqli_fetch_array(
                        $all_medications,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $medications["medication_code"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $employees["name"] . " ".$employees["medication_code"];
                        // To show the medication name to the user
                    ?>
                </option>
                <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <select name="medication">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($medications = mysqli_fetch_array(
                        $all_medications,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $medications["medication_code"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $employees["name"] . " ".$employees["medication_code"];
                        // To show the medication name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <label for="severity">Medication Severity:</label>
                           <select name="severity" id="severity">
                           <option value="">Select...</option>
                           <option value="s">(S) Severe Interaction</option>
                           <option value="m">(M) Moderate Interaction</option>
                           <option value="l">(L) Little Interaction</option>
                           <option value="n">(N) No Interaction</option>
        <br>
            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>