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

$cityData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['city_ids'])) {
    $city_ids = $_POST['city_ids'];

    // Prepare query
    $placeholders = implode(',', array_fill(0, count($city_ids), '?'));
    $stmt = $conn->prepare("SELECT City, Country, AQI FROM info WHERE id IN ($placeholders)");

    $types = str_repeat('i', count($city_ids));
    $stmt->bind_param($types, ...$city_ids);
    $stmt->execute();

    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $cityData[] = $row;
    }

    $stmt->close();
} else {
    die("No cities selected.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AQI Info</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      padding: 40px;
      text-align: center;
    }
    table {
      margin: 0 auto;
      border-collapse: collapse;
      width: 80%;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    tr:nth-child(even) {
      background: #f1f1f1;
    }
  </style>
</head>
<body>
  <h2>Selected City AQI Information</h2>
  <table>
    <thead>
      <tr>
        <th>City</th>
        <th>Country</th>
        <th>AQI</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($cityData as $city): ?>
        <tr>
          <td><?= htmlspecialchars($city['City']) ?></td>
          <td><?= htmlspecialchars($city['Country']) ?></td>
          <td><?= htmlspecialchars($city['AQI']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
