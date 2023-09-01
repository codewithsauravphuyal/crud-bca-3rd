<?php
$id = "";
$name = "";
$address = "";
$phone = "";

$errorMessage = "";
$successMessage = "";

// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crudtest";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET['id'];

    // Read the row of the selected users from the database table
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $name = $row["name"];
    $address = $row["address"];
    $phone = $row["phone"];
    

} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Post method: Update the data of the users
    $id = $_POST["id"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    


    $sql = "UPDATE users SET name='$name', phone='$phone', address='$address' WHERE id=$id";
    $result = $conn->query($sql);

    if (!$result) {
        $errorMessage = "Invalid query: " . $conn->error;
    } else {
        $successMessage = "users updated successfully";
        // Move the redirect here, after the success message
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
</head>

<body>
    <div class="container my-5">
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <h2>New users</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label>Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                <label>Address</label>
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                <label>Phone</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>$successMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
            }
            ?>
                    <button type="submit">Submit</button>
                    <a href="/crudtest/index.php">Exit</a>
        </form>
    </div>
</body>

</html>