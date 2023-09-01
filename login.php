<?php
// Start or resume the session
session_start();

// Simulated user credentials (Replace these with your actual user data)
$validUsername = "user123";
$validPassword = "password123";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the provided credentials are correct
    if ($username === $validUsername && $password === $validPassword) {
        // Set the user session variable
        $_SESSION['user'] = $username;

        // Redirect to the protected page
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid credentials. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>

<h2>Login</h2>
<?php if(isset($error)) { echo '<p style="color: red;">' . $error . '</p>'; } ?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>

</body>
</html>
