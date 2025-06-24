<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirm-password']);
    $countryCode = htmlspecialchars($_POST['Country-Code']);
    $preferredCity = htmlspecialchars($_POST['preferred-city']);
    $terms = isset($_POST['terms']) ? 'Agreed' : 'Not Agreed';

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    echo "<h2>Registration Successful!</h2>";
    echo "<p>Full Name: $fullname</p>";
    echo "<p>Email: $email</p>";
    echo "<p>Location: $countryCode</p>";
    echo "<p>Preferred City: $preferredCity</p>";
    echo "<p>Terms: $terms</p>";
} else {
    echo "Invalid request.";
}
?>
