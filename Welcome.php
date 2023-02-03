<?php
include_once('connection.php');

$sql = "SELECT COUNT(DISTINCT o.id) AS 'Owners',
               COUNT(DISTINCT d.id) AS 'Total Dogs',
               COUNT(DISTINCT e.id) AS 'Total Events'
        FROM owners o
        INNER JOIN dogs d ON o.id = d.owner_id
        INNER JOIN entries en ON d.id = en.dog_id
        INNER JOIN competitions c ON en.competition_id = c.id
        INNER JOIN events e ON c.event_id = e.id";

// Execute the SELECT statement
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
  // Output data of each row
  while($row1 = $result->fetch_assoc()) {
    $num_owners = $row1["Owners"];
    $num_dogs = $row1["Total Dogs"];
    $num_events = $row1["Total Events"];
  }
} else {
  // If no rows are returned, it will display no results
  echo "Error!";
}
// heading and table
echo "<div style='text-align:center'>";
echo "<h1 style='color: #4CAF50; font-weight: bold;'> Welcome to Poppleton Dogs Show! </h1>";
echo "<h1 style='font-style: italic;'> This year $num_owners owners entered $num_dogs dogs in $num_events events! </h1>";
echo "</div>";

echo "<table style='border: 2px solid #4CAF50; margin: 0 auto;'>";
echo "<tr style='background-color: #eee'>";
echo "<th style='border: 2px solid #4CAF50; padding: 10px'> Number </th>";
echo "<th style='border: 2px solid #4CAF50; padding: 10px'> Dogs Name </th>";
echo "<th style='border: 2px solid #4CAF50; padding: 10px'> Breed </th>";
echo "<th style='border: 2px solid #4CAF50; padding: 10px'> Average Score </th>";
echo "<th style='border: 2px solid #4CAF50; padding: 10px'> Owner Name </th>";
echo "<th style='border: 2px solid #4CAF50; padding: 10px'> Owner Email </th>";
echo "</tr>";

$query4 = "SELECT dog_id, AVG(score) FROM entries GROUP BY dog_id HAVING COUNT(competition_id) > 1 ORDER BY AVG(score) DESC LIMIT 10";
$output3 = $conn->query($query4);

$number = 1;

while ($row = mysqli_fetch_assoc($output3)) {
    $dog = $row["dog_id"];

    $query5 = "SELECT * FROM dogs WHERE id = $dog"; 
    $output4 = mysqli_fetch_assoc($conn->query($query5));

    $breed = $output4["breed_id"];
    $query6 = "SELECT * FROM breeds WHERE id = $breed";
    $output5 = mysqli_fetch_assoc($conn->query($query6));

    $owners = $output4["owner_id"];
    $query7 = "SELECT * FROM owners WHERE id = $owners";
    $output6 = mysqli_fetch_assoc($conn->query($query7));


    echo "<tr>";
    echo "<td>$number</td>";
    echo "<td>" . $output4['name'] . "</td>";
    echo "<td>" . $output5['name'] . "</td>";
    echo "<td>" . $row['AVG(score)'] . "</td>";
    echo "<td><a href='owner.php?name=" . $output6['name'] . "'>" . $output6['name'] . "</a></td>";
    echo "<td><a href=mailto:" . $output6['email'] . ">" . $output6['email']. "</a></td>";
    echo "</tr>";

    $number++;
}

echo "</table>";

?>

