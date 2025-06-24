<?php
// DB connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'aqi_app';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cities
$sql = "SELECT id, City FROM info ORDER BY City ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Select Cities</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      text-align: center;
      padding: 40px;
    }
    .container {
      display: inline-block;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h2 {
      color: rgb(56, 91, 126);
    }
    .city-list {
      text-align: left;
      margin: 20px 0;
    }
    .city-list label {
      display: block;
      padding: 5px 0;
    }
    button {
      background-color: rgb(56, 91, 126);
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background-color: rgb(77, 77, 146);
    }
    .error {
      color: red;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Select Cities (up to 10)</h2>
    <form action="show.php" method="POST" onsubmit="return validateSelection();">
      <div class="city-list">
        <?php
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo '<label><input type="checkbox" name="city_ids[]" value="'. $row['id'] .'"> '. htmlspecialchars($row['City']) .'</label>';
          }
        } else {
          echo "<p>No cities found.</p>";
        }
        ?>
      </div>
      <button type="submit">Show AQI Info</button>
      <p class="error" id="error-message"></p>
    </form>
  </div>

  <script>
    function validateSelection() {
      const checked = document.querySelectorAll('input[name="city_ids[]"]:checked');
      const errorMsg = document.getElementById("error-message");
      errorMsg.textContent = "";
      if (checked.length === 0) {
        errorMsg.textContent = "Please select at least one city.";
        return false;
      }
      if (checked.length > 10) {
        errorMsg.textContent = "You can select up to 10 cities only.";
        return false;
      }
      return true;
    }
  </script>
</body>
</html>

<?php $conn->close(); ?>
