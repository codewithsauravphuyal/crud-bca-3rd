<?php
// Start or resume the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    $loggedInUser = $_SESSION['user'];
    echo "Welcome, $loggedInUser! You are logged in.";
} else {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CURD-Bca3rd</title>
</head>
<body>
    <?php
$host = "localhost";
$username = "root";
$password = "";
$database = "crudtest";

$conn = new mysqli($host, $username, $password, $database);

if ($conn) {
    print("Connected ");
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Insert the form data into the database
    $insertQuery = "INSERT INTO users (name, address, phone) VALUES ('$name', '$address', '$phone')";
    $insertResult = $conn->query($insertQuery);

    if ($insertResult === false) {
        echo "Error executing the query: " . $conn->error;
    }
}

if (isset($_GET["delete_id"])) {
    $deleteId = $_GET["delete_id"];

    // Delete the client from the database
    $deleteQuery = "DELETE FROM users WHERE id = '$deleteId'";
    $deleteResult = $conn->query($deleteQuery);

    if ($deleteResult) {
        $successMessage = "Client deleted successfully";
        header("location: /crudtest/index.php?success=delete");
        exit;
    } else {
        $errorMessage = "Error occurred while deleting the client";
    }
}

 // Logout logic
 if (isset($_GET['logout'])) {
    // Destroy the session and unset session variables
    session_unset();
    session_destroy();

    // Redirect to the login page after logout
    header("Location: login.php");
    exit();
}
?>
<div style="display: flex; justify-content: end;">
            <a href="index.php?logout=true">Logout</a>

        </div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<div class="form">
    <form action="" method="post">
        <label for="name">Name</label><br>
        <input type="text" name="name" id="name" required><br>
        <label for="address">Address</label><br>
        <input type="text" name="address" id="address" required><br>
        <label for="phone_number">Phone Number</label><br>
        <input type="text" name="phone" id="phone" required><br>
        <button type="submit">Submit</button>
    </form>
</div>

<div class="table" style="margin-top:10px;">
    <table border=1>
        <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Action</th>
        </thead>
        <tbody>
        <?php
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            if (!$result) {
                die("Invalid query: " . $conn->error);
            }

            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>$row[id]</td>
                    <td>$row[name]</td>
                    <td>$row[address]</td>
                    <td>$row[phone]</td>
                    <td>
                        <a  href='/crudtest/edit.php?id=$row[id]'>Edit</a>
                        <a  href='/crudtest/index.php?delete_id=$row[id]'>Delete</a>
                    </td>
                </tr>
                ";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>