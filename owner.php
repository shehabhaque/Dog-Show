<style>
  .owner-details {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .owner-details li {
    margin: 20px 0;
    font-size: 18px;
  }

  .highlight {
    font-weight: bold;
  }

  .btn {
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
  }

  .btn-primary {
    background-color: #4CAF50;
  }
</style>

  <?php
  
  // Include the database connection file
  include_once('connection.php');

  // Check if the 'name' parameter is set and not empty
  if (isset($_REQUEST['name']) && !empty($_REQUEST['name'])) {
    $name = $_REQUEST['name'];
  } else {
    die('Owner is not in the list');
  }

  // Select the owner with the specified name from the database
  $query = "SELECT * FROM owners WHERE name = '$name'";
  $result = $conn->query($query);

  // Check if the query was successful
  if (!$result) {
    die("Error!" . $conn->error);
  }

  // Check if the owner was found
  if ($result->num_rows == 0) {
    die("Owner is not in the list");
  }

  // Fetch the owner data as an associative array
  $data = mysqli_fetch_array($result, MYSQLI_ASSOC);

  // Display the owner details
  echo "<h1>Owner Details</h1>";
  echo "<hr>";
  echo "<ul class='owner-details'>";
  echo "  <li>Name:
  <span class='highlight'>" . $data['name'] . "</span></li>";
  echo "  <li>Email: <span class='highlight'>" . $data['email'] . "</span></li>";
  echo "  <li>Phone: <span class='highlight'>" . $data['phone'] . "</span></li>";
  echo "  <li>Address: <span>" . $data['address'] . "</span></li>";
  echo "</ul>";
  echo "<div style='text-align: center; margin-top: 20px;'>";
  echo "  <button onclick='history.go(-1)' class='btn'>Back to Search</button>";
  echo "</div>";
  
  //closing the database connection
  $conn->close();
  ?>
  </body>
  </html>

