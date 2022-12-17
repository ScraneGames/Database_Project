<!DOCTYPE html>
<html>

<head>
    <title>People and Corporations With Shares</title>
</head>


<body>
    <center>
        <?php



        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php

        $sql = "SELECT * FROM ownership_perc ORDER BY ownership_id";
        $result = mysqli_query($conn,$sql);

$result = mysqli_query($conn,$sql);
echo "All People and Corporations With Shares in the Clinic";
echo "<br>";
echo "<table border='1'>
<tr>
<th>Owner Name</th>
<th>Shares</th>
<th>Percentage of Ownership</th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['shares'] . "</td>";
    echo "<td>" . $row['perc'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";
$conn->close();
?>

        </center>
    </body>
</html>
